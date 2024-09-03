<?php

namespace App\Livewire\Payment;

use App\Models\Action;
use App\Models\Batch;
use App\Models\DrugMedDev;
use App\Models\HealthWorker;
use App\Models\Laborate;
use App\Models\MedicalRecord;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\SipFee;
use App\Models\StockLedger;
use App\Models\TmpData;
use App\Models\Transaction;
use App\Models\User;
use DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    public $medical_record_uuid;
    public $transaction;

    #[Validate('required', as: 'Pasien')]
    public $user_id = null;

    #[Validate('required|date', as: 'Tanggal')]
    public $date;

    public $doctor_name;
    public $doctor_id = 0;
    public $medical_record_number;

    public $transaction_uuid;
    public $nik;

    public $listActions;
    public $actions = [];
    public $drugMedDevs = [];

    public $purchase_drug = false;
    public $notification;

    public $paymentMethods = [];

    public $laborates = [];
    public $kembalian = 0;
    public $grand_total = 0;

    public function mount(Transaction $transaction)
    {
        $transaction->load('patient.medicalRecords', 'patient.patient', 'actions', 'drugMedDevs', 'medicalRecord.user.patient', 'medicalRecord.doctor', 'laborates', 'paymentMethods');
        TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('payment.edit')->delete();

        $this->transaction = $transaction;
        $this->date = $transaction->date;

        $this->doctor_name = $transaction?->medicalRecord?->doctor->name ?? '-';
        $this->doctor_id = $transaction->medicalRecord->doctor_id ?? 0;

        $this->user_id = $transaction->patient_id;
        $this->nik = $transaction->patient?->patient?->nik;
        $this->medical_record_number = $transaction?->medicalRecord?->user?->patient->patient_number;
        foreach ($transaction->actions as $a) {
            $this->actions[] = [
                'temp_id' => rand(),
                'item_id' => $a->id,
                'qty' => $a->pivot->qty,
                'uom' => '-',
                'type' => '-',
                'price' => $a->price,
                'discount' => $a->pivot->discount,
                'isPromo' => $a->pivot->isPromo,
                'total' => $a->pivot->qty * $a->price,
            ];
        }

        foreach ($transaction->drugMedDevs as $d) {
            $this->drugMedDevs[] = [
                'temp_id' => rand(),
                'item_id' => $d->id,
                'qty' => $d->pivot->qty,
                'uom' => $d->uom,
                'type' => $d->pivot?->how_to_use ?? '-',
                'rule' => $d->pivot?->rule ?? '-',
                'price' => $d->selling_price,
                'discount' => $d->pivot->discount,
                'isPromo' => $d->pivot->isPromo,
                'total' => $d->pivot->qty * $d->selling_price,
            ];
        }

        foreach ($transaction->laborates as $value) {
            $this->laborates[] = [
                'temp_id' => rand(),
                'item_id' => $value->id,
                'qty' => $value->pivot->qty,
                'price' => $value->price,
                'discount' => $value->pivot->discount,
                'total' => $value->price
            ];
        }
        foreach ($transaction->paymentMethods as $paymentMethod) {
            $this->paymentMethods[$paymentMethod->name] = [
                'bank' => $paymentMethod->pivot->bank,
                'amount' => $paymentMethod->pivot->amount
            ];
        }

        if (!$transaction->medicalRecord) {
            $this->purchase_drug = true;
        }
    }

    public function render()
    {
        $this->authorize('update', $this->transaction);
        $mrToday = MedicalRecord::where('date', date('Y-m-d'))->pluck('id')->toArray();
        return view('livewire.payment.edit', [
            'users' => !$this->purchase_drug ?
                User::whereHas('medicalRecords', function ($query) {
                    $query->whereDate('date', today());
                })
                ->whereDoesntHave('medicalRecords.transaction', function ($query) use ($mrToday) {
                    $query->whereIn('medical_records.id', $mrToday)
                        ->whereNotNull('id');
                })
                ->get() : User::whereHas('patient')->get(),
            'doctors' => User::with('healthWorker')->whereHas('healthWorker', function ($query) {
                $query->where('position', 'Dokter');
            })->get(),
            'medicalRecords' => MedicalRecord::with('doctor', 'nurse', 'usgs','registration','registration.branch', 'drugMedDevs', 'actions', 'laborate', 'firstEntry')->where('user_id', empty($this->user_id) ? 0 : $this->user_id)->latest()->get(),
            'actionsOption' => Action::all(),
            'drugMedDevsOption' => DrugMedDev::all(),
            'laboratesOption' => Laborate::all(),

        ]);
    }

    #[On('payment-create')]
    public function save()
    {

        $this->notification = null;
        $this->validate();
        $this->authorize('update', $this->transaction);
        DB::beginTransaction();
        try {
            $totalDrug = array_reduce($this->drugMedDevs, function ($a, $b){
                return $a + ((int)$b['qty'] * (int) $b['price'] - (int) $b['discount']);
            }, 0);
            $totalAction = array_reduce($this->actions, function ($a, $b){
                return $a + ((int)$b['qty'] * (int) $b['price'] - (int) $b['discount']);
            }, 0);
            $totalLaborate = array_reduce($this->laborates, function ($a, $b){
                return $a + ((int)$b['qty'] * (int) $b['price'] - (int) $b['discount']);
            }, 0);
            $grandTotal = $totalDrug + $totalAction + $totalLaborate;

            $totalAmount = array_reduce($this->paymentMethods, function($carry, $item) {
                return $carry + (int)filter_var($item['amount'], FILTER_SANITIZE_NUMBER_INT);
            }, 0);

            $medicalRecord = MedicalRecord::with('actions', 'drugMedDevs', 'registration')->where('user_id', $this->user_id)->where('date', date('Y-m-d'))->orderBy('id', 'desc')->first();
            if($grandTotal > $totalAmount){
                $this->alert('error', 'Pembayaran Gagal', [
                    'toast' => false,
                    'position' => 'center',
                    'text' => 'Jumlah pembayaran kurang dari Grand Total',
                    'showConfirmButton' => true
                ]);
                return;
            }
            if (!$medicalRecord?->doctor_id && !$this->doctor_id && !$this->purchase_drug) {
                $this->alert('error', 'Pembayaran Gagal', [
                    'toast' => false,
                    'position' => 'center',
                    'text' => 'Dokter wajib diisi',
                    'showConfirmButton' => true
                ]);
                return;
            }

            if (!$this->purchase_drug && !count($this->actions) && !count($this->drugMedDevs) && !count($this->laborates)) {
                $this->alert('error', 'Pembayaran Gagal', [
                    'toast' => false,
                    'position' => 'center',
                    'text' => 'Belum ada tindakan atau obat yang dipilih',
                    'showConfirmButton' => true
                ]);
                return;
            }

            if ($this->purchase_drug && !count($this->drugMedDevs)) {
                $this->alert('error', 'Pembayaran Gagal', [
                    'toast' => false,
                    'position' => 'center',
                    'text' => 'Belum ada obat yang dipilih',
                    'showConfirmButton' => true
                ]);
                return;
            }

            foreach ($this->actions as $value) {
                if ($value['item_id'] == '' || $value['item_id'] == 0) {
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'tindakan harus diisi',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                if ($value['qty'] == 0) {
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'jumlah tindakan harus diisi',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                $action = Action::find($value['item_id']);
                if (!$action) {
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'tindakan tidak ditemukan',
                        'showConfirmButton' => true
                    ]);
                    return;
                }
            }

            foreach ($this->drugMedDevs as $value) {
                if ($value['item_id'] == '' || $value['item_id'] == 0) {
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Obat/alkes harus diisi',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                if ($value['qty'] == 0) {
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Jumlah obat/alkes harus diisi',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                $drugMedDev = DrugMedDev::find($value['item_id']);
                if (!$drugMedDev) {
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Obat/alkes tidak ditemukan',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                if (Setting::whereField('is_can_minus')->first()->value == 0) {
                    $qtySum = StockLedger::query()
                        ->where('document_reference', $this->transaction->transaction_number)
                        ->where('item_id', $drugMedDev->id)
                        ->sum('current_qty');
                    if ($qtySum < $value['qty']) {
                        $this->alert('error', 'Pembayaran Gagal', [
                            'toast' => false,
                            'position' => 'center',
                            'text' => 'Stok obat kurang',
                            'showConfirmButton' => true
                        ]);
                        return;
                    }
                }
            }

            foreach ($this->laborates as $value) {
                if ($value['item_id'] == '' || $value['item_id'] == 0) {
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Laborate harus diisi',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                $laborate = Laborate::find($value['item_id']);
                if (!$laborate) {
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Laborate tidak ditemukan',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                if ($value['qty'] == 0) {
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Jumlah laborate harus diisi',
                        'showConfirmButton' => true
                    ]);
                    return;
                }
            }

            $this->transaction->doctor_id = $medicalRecord?->doctor_id ?? $this->doctor_id > 0 ? $this->doctor_id : null;
            $this->transaction->save();

            $laborate = [];
            $action = [];
            $drugMedDevSelected = [];
            $paymentMethods = [];

            foreach ($this->actions as $value) {
                $doctorFee = 0;
                $discount = (int) (str_replace('.','',$value['discount']));

                $doctor = HealthWorker::where('user_id',$medicalRecord?->doctor_id ?? 0)->first();
                $fee = SipFee::where('action_id',$value['item_id'])->first();

                if($doctor && $fee){
                    if($doctor->practice_license){
                        $doctorFee = (int)$fee->sip_fee;
                    }else{
                        $doctorFee = (int)$fee->non_sip_fee;
                    }
                }

                if ($value['discount'] > 0) {
                    if (!$value['isPromo']) {
                        $doctorFee = $doctorFee * (( $value['price'] - $discount)/ $value['price']);
                    }
                }

                $action[$value['item_id']] = [
                    'doctor_fee' => ceil($doctorFee),
                    'qty' => $value['qty'],
                    'discount' => $discount ?? 0,
                    'price' => $value['price'],
                    'isPromo' => $value['isPromo']
                ];
            }

            $stockLedgers = StockLedger::query()
                ->with('batch')
                ->where('document_reference', $this->transaction->transaction_number)
                ->get();

            foreach ($this->transaction->drugMedDevs as  $drugMedDev) {
                $stockLedgersFiltered = $stockLedgers->filter(fn ($stockLedger) => $stockLedger->batch->item_id == $drugMedDev->id)->sortByDesc('id');
                $usedQty = $drugMedDev->pivot->qty;
                foreach ($stockLedgersFiltered as  $stockLedger) {
                    $stockLedgerBatch = StockLedger::query()
                        ->where('batch_reference', $stockLedger->batch->batch_number)
                        ->where('created_at', '>', $stockLedger->created_at)
                        ->latest()
                        ->get();

                    $currentQty = $stockLedger->batch->qty;
                    $maxQty = $stockLedger->batch->qty_ori;

                    $available_space = $maxQty - $currentQty;
                    if ($usedQty <= $available_space) {
                        $stockLedger->batch->update([
                            'qty' => $stockLedger->batch->qty + $usedQty
                        ]);
                        $usedQty = 0;
                        $stockLedgerBatch
                            ->each(fn ($stockLedger) => $stockLedger->update([
                                'qty' => $usedQty
                            ]));
                    } else {
                        $stockLedger->batch->update([
                            'qty' => $stockLedger->batch->qty + $available_space,
                        ]);
                        $usedQty -= $available_space;
                        $stockLedgerBatch
                            ->each(fn ($stockLedger) => $stockLedger->update([
                                'qty' => $stockLedger->qty + $usedQty,
                                'current_qty' => $stockLedger->current_qty + $usedQty
                            ]));
                    }

                    if ($usedQty <= 0) break;
                }
            }

            $this->transaction->drugMedDevs()->detach();
            $stockLedgers->each(fn ($stockLedger) => $stockLedger->delete());

            foreach ($this->drugMedDevs as $value) {
                $qtyTmp = $value['qty'];
                $batchId = null;

                $isNotEmpty = true;
                while ($isNotEmpty) {
                    $batch =  Batch::query()
                        ->whereHas('stockEntry', function ($query) {
                            $query->where('branch_id', auth()->user()->branch_filter);
                        })
                        ->where('qty', '>', 0)
                        ->where('item_id', $value['item_id'])
                        ->orderBy('expired_date', 'asc')
                        ->first();

                    if ($batch) {
                        StockLedger::create([
                            'document_reference' => $this->transaction->transaction_number,
                            'current_qty' => $batch->qty,
                            'in' => 0,
                            'out' => ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp),
                            'item_id' => $batch->item_id,
                            'qty' => $batch->qty - ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp),
                            'batch_reference' => $batch->batch_number
                        ]);

                        $qtyTmpTmp = $qtyTmp;
                        $qtyTmp -= ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp);

                        $batch->update([
                            'qty' => $batch->qty - ($qtyTmpTmp - $qtyTmp)
                        ]);

                        $batchId = $batch->id;
                    }
                    if ($qtyTmp <= 0 || !$batch) {
                        $isNotEmpty = false;
                    }
                }

                $how_to_use = $medicalRecord ? $medicalRecord->drugMedDevs()->where('drug_med_dev_id', $value['item_id'])->first() : NULL;
                $drugMedDevSelected[$value['item_id']] = [
                    'qty' => $value['qty'],
                    'discount' => $value['discount'] ?? 0,
                    'batch_id' => $batchId,
                    'how_to_use' => $how_to_use->pivot->how_to_use ?? $value['type'],
                    'rule' => $how_to_use->pivot->rule ?? $value['rule'],
                    'price' => (int) $value['price'],
                    'isPromo' => $value['isPromo']
                ];
            }

            foreach ($this->laborates as $value) {
                $laborate[$value['item_id']] = [
                    'qty' => $value['qty'],
                    'discount' => $value['discount'] ?? 0,
                    'price' =>  (int) $value['price']

                ];
            }

            foreach ($this->paymentMethods as $key => $value) {
                $paymentMethod = PaymentMethod::query()
                    ->where('name', $key)
                    ->first();
                if ($paymentMethod) {
                    $paymentMethods[$paymentMethod->id] = [
                        'amount' => (int)filter_var($value['amount'], FILTER_SANITIZE_NUMBER_INT),
                        'bank' => $value['bank'],
                        'change' => $key == 'Cash' ? (int)filter_var($this->kembalian , FILTER_SANITIZE_NUMBER_INT) : 0

                    ];
                }
            }

            $this->transaction->actions()->sync($action);
            $this->transaction->drugMedDevs()->sync($drugMedDevSelected);
            $this->transaction->laborates()->sync($laborate);
            $this->transaction->paymentMethods()->sync($paymentMethods);

            DB::commit();
            Toaster::success('Pembayaran berhasil disimpan');
            return $this->redirectRoute('payment.show', [$this->transaction->uuid], navigate: true);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            Toaster::error('Gagal simpan. Cx`Zoba beberapa saat lagi');
        }
    }

    public function getAction($temp_id, $id)
    {
        if (empty($id)) {
            return;
        }
        $action = Action::find($id);
        if ($action) {
            $this->dispatch('get-action-result', item: $action, temp_id: $temp_id);
        }
    }

    public function getDrugMedDev($temp_id, $id)
    {
        if (empty($id)) {
            return;
        }
        $drugMedDev = DrugMedDev::find($id);
        if ($drugMedDev) {
            $this->dispatch('get-drug-med-dev-result', item: $drugMedDev, temp_id: $temp_id);
        }
    }

    public function getLaborate($temp_id, $id)
    {
        if (empty($id)) {
            return;
        }
        $laborate = Laborate::find($id);
        if ($laborate) {
            $this->dispatch('get-laborate-result', item: $laborate, temp_id: $temp_id);
        }
    }
}
