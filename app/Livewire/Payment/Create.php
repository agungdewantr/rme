<?php

namespace App\Livewire\Payment;

use App\Models\Action;
use App\Models\Batch;
use App\Models\Branch;
use App\Models\DrugMedDev;
use App\Models\HealthWorker;
use App\Models\Laborate;
use App\Models\MedicalRecord;
use App\Models\PaymentMethod;
use App\Models\Poli;
use App\Models\Registration;
use App\Models\Setting;
use App\Models\SipFee;
use App\Models\StockLedger;
use App\Models\TmpData;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Symfony\Component\Console\Output\ConsoleOutput;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;

    public $medical_record_uuid;
    #[Validate('required', as: 'Poli')]
    public $poli_id;
    #[Validate('required', as: 'Kedatangan')]
    public $estimated_arrival;

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
    public $kembalian = 0;
    public $grand_total = 0;

    public $laborates = [];
    public $paymentMethods = [];

    public function mount($medical_record_uuid = null)
    {
        $this->listActions = Action::all()->toArray();
        $total = 0;
        TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('payment.create')->delete();
        if ($medical_record_uuid != null) {
            $this->medical_record_uuid = $medical_record_uuid;
            $medicalRecord = MedicalRecord::with('actions', 'registration', 'drugMedDevs', 'doctor', 'user.patient')->where('uuid', $medical_record_uuid)->first();
            if ($medicalRecord) {
                $this->doctor_name = $medicalRecord->doctor ? $medicalRecord->doctor->name : '-';
                $this->doctor_id = $medicalRecord->doctor_id ?? 0;
                $this->estimated_arrival = $medicalRecord->registration?->estimated_arrival;

                $poli = Poli::where('name', $medicalRecord->registration->poli)->first();
                $this->poli_id = $poli->id ?? NULL;

                $this->user_id = $medicalRecord->user_id;
                $this->nik = $medicalRecord->user->patient->nik;
                $this->medical_record_number = $medicalRecord->user->patient->patient_number;
                foreach ($medicalRecord->actions as $a) {
                    $this->actions[] = [
                        'temp_id' => rand(),
                        'item_id' => $a->id,
                        'qty' => $a->pivot->total,
                        'uom' => '-',
                        'type' => '-',
                        'price' => $a->price,
                        'discount' => 0,
                        'total' => $a->pivot->total * $a->price,
                    ];
                }

                foreach ($medicalRecord->drugMedDevs as $d) {
                    $this->drugMedDevs[] = [
                        'temp_id' => rand(),
                        'item_id' => $d->id,
                        'qty' => $d->pivot->total,
                        'uom' => $d->uom,
                        'type' => $d->pivot->how_to_use,
                        'rule' => $d->pivot->rule,
                        'price' => $d->selling_price,
                        'discount' => 0,
                        'total' => $d->pivot->total * $d->selling_price,
                    ];
                }

                foreach ($medicalRecord->laborate as $value) {
                    $this->laborates[] = [
                        'temp_id' => rand(),
                        'item_id' => $value->id,
                        'qty' => 1,
                        'price' => $value->price,
                        'discount' => 0,
                        'total' => $value->price
                    ];

                    $total += $value->price;
                }
            }
        }
        $paymentMethods = PaymentMethod::all();
        foreach ($paymentMethods as $paymentMethod) {
            $this->paymentMethods[$paymentMethod->name] = [
                'bank' => '',
                'amount' => 0
            ];
        }
        $this->date = Carbon::now()->format('Y-m-d');
    }

    public function updated($property)
    {
        if ($property === 'user_id') {
            $this->transaction_uuid = NULL;
            TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('payment.create')->delete();
            $medicalRecord = null;
            $this->dispatch('grand-total-change');
            if ($this->user_id) {
                $medicalRecord = MedicalRecord::query()
                    ->with('actions', 'drugMedDevs', 'doctor', 'laborate')
                    ->where('user_id', $this->user_id)
                    ->where('date', Carbon::parse($this->date)->format('Y-m-d'))
                    ->orderBy('id', 'desc')
                    ->first();
            }
            if ($medicalRecord) {
                $this->doctor_name = $medicalRecord->doctor ? $medicalRecord->doctor->name : '-';
                $this->doctor_id = $medicalRecord->doctor_id ?? 0;
                $this->medical_record_number = $medicalRecord->user->patient->patient_number;
                $this->nik = $medicalRecord->user->patient->nik;
                $this->estimated_arrival = $medicalRecord->registration?->estimated_arrival;

                $poli = Poli::where('name', $medicalRecord->registration->poli)->first();
                $this->poli_id = $poli->id ?? NULL;
                foreach ($medicalRecord->actions as $a) {
                    $this->actions[] = [
                        'temp_id' => rand(),
                        'item_id' => $a->id,
                        'qty' => $a->pivot->total,
                        'uom' => '-',
                        'type' => '-',
                        'price' => $a->price,
                        'discount' => 0,
                        'total' => $a->pivot->total * $a->price,
                    ];
                }

                foreach ($medicalRecord->drugMedDevs as $d) {
                    $this->drugMedDevs[] = [
                        'temp_id' => rand(),
                        'item_id' => $d->id,
                        'qty' => $d->pivot->total,
                        'uom' => $d->uom,
                        'type' => $d->pivot->how_to_use,
                        'rule' => $d->pivot->rule,
                        'price' => $d->selling_price,
                        'discount' => 0,
                        'total' => $d->pivot->total * $d->selling_price,
                    ];
                }

                foreach ($medicalRecord->laborate as $value) {
                    $temp_id = rand();
                    $this->laborates[] = [
                        'temp_id' => $temp_id,
                        'item_id' => $value->id,
                        'qty' => 1,
                        'price' => $value->price,
                        'discount' => 0,
                        'total' => $value->price
                    ];
                }
            } else {
                $user = User::with('patient')->where('id', empty($this->user_id) ? 0 : $this->user_id)->first();
                if ($user) {
                    $this->nik = $user->patient->nik;
                } else {
                    $this->nik = '';
                }
                $this->doctor_name = '';
                $this->medical_record_number = '';
            }
        }
        if ($property === 'date') {
            $this->date = Carbon::parse($this->date)->setTimezone('Asia/Jakarta')->toDateString();
        }
        $mrToday = MedicalRecord::where('date', $this->date)->pluck('id')->toArray();
        $users = !$this->purchase_drug ?
            User::whereHas('medicalRecords', function ($query) {
                $query->whereDate('date', $this->date);
            })
            ->whereDoesntHave('medicalRecords.transaction', function ($query) use ($mrToday) {
                $query->whereIn('medical_records.id', $mrToday)
                    ->whereNotNull('id');
            })->get() : User::whereHas('patient')->get();
        if ($property === 'purchase_drug' || $property === 'date') {
            $this->dispatch('refresh-select2', users: $users);
            $this->nik = null;
        }
    }

    public function render()
    {
        $this->authorize('create', Transaction::class);
        $mrToday = MedicalRecord::where('date', $this->date)->pluck('id')->toArray();
        $branch = Branch::with('poli')->where('id', auth()->user()->branch_filter)->first();
        return view('livewire.payment.create', [
            'users' => !$this->purchase_drug ?
                User::whereHas('medicalRecords', function ($query) {
                    $query->whereDate('date', $this->date);
                })->whereHas('medicalRecords.registration', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_filter);
                })
                ->whereDoesntHave('medicalRecords.transaction', function ($query) use ($mrToday) {
                    $query->whereIn('medical_records.id', $mrToday)
                        ->whereNotNull('id');
                })
                ->get() : User::whereHas('patient')->get(),
            'doctors' => User::with('healthWorker')->whereHas('healthWorker', function ($query) {
                $query->where('position', 'Dokter');
            })->get(),
            'medicalRecords' => MedicalRecord::with('nurse', 'firstEntry', 'registration', 'registration.branch','doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')->where('user_id', empty($this->user_id) ? 0 : $this->user_id)->latest()->get(),
            'actionsOption' => Action::all(),
            'drugMedDevsOption' => DrugMedDev::with(['batches' => function ($query) {
                $query->whereHas('stockEntry', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_filter);
                });
            }])->orderBy('name', 'asc')->get(),
            'laboratesOption' => Laborate::all(),
            'polis' => $branch
        ]);
    }

    #[On('payment-create')]
    public function save()
    {
        $this->notification = null;
        $this->validate();
        $this->authorize('create', Transaction::class);
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
            $medicalRecord = null;
            if($grandTotal > $totalAmount){
                $this->alert('error', 'Pembayaran Gagal', [
                    'toast' => false,
                    'position' => 'center',
                    'text' => 'Jumlah pembayaran kurang dari Grand Total',
                    'showConfirmButton' => true
                ]);
                return;
            }
            if (!$this->purchase_drug) {
                $medicalRecord = MedicalRecord::with('actions', 'drugMedDevs', 'registration')->where('user_id', $this->user_id)->where('date', Carbon::parse($this->date)->format('Y-m-d'))->orderBy('id', 'desc')->first();
            }
            if (!$medicalRecord?->doctor_id && !$this->doctor_id && !$this->purchase_drug) {
                $this->alert('error', 'Pembayaran Gagal', [
                    'toast' => false,
                    'position' => 'center',
                    'text' => 'Dokter wajib diisi',
                    'showConfirmButton' => true
                ]);
                return;
                // $this->notification = 'Dokter wajib diisi';
                // return;
            }

            if (!$this->purchase_drug && !count($this->actions) && !count($this->drugMedDevs) && !count($this->laborates)) {
                // $this->notification = 'Belum ada tindakan atau obat yang dipilih';
                // return;
                $this->alert('error', 'Pembayaran Gagal', [
                    'toast' => false,
                    'position' => 'center',
                    'text' => 'Belum ada tindakan atau obat yang dipilih',
                    'showConfirmButton' => true
                ]);
                return;
            }

            if ($this->purchase_drug && !count($this->drugMedDevs)) {
                // $this->notification = 'Belum ada obat yang dipilih';
                // return;
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
                    // $this->notification = 'Pembayaran gagal disimpan, tindakan harus diisi';
                    // return;
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'tindakan harus diisi',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                if ($value['qty'] == 0) {
                    // $this->notification = 'Pembayaran gagal disimpan, jumlah tindakan harus diisi';
                    // return;
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
                    // $this->notification = 'Pembayaran gagal disimpan, tindakan tidak ditemukan';
                    // return;
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
                    // $this->notification = 'Pembayaran gagal disimpan, obat/alkes harus diisi';
                    // return;
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Obat/alkes harus diisi',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                if ($value['qty'] == 0) {
                    // $this->notification = 'Pembayaran gagal disimpan, jumlah obat/alkes harus diisi';
                    // return;
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
                    // $this->notification = 'Pembayaran gagal disimpan, obat/alkes tidak ditemukan';
                    // return;
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Obat/alkes tidak ditemukan',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                if (Setting::whereField('is_can_minus')->first()->value == 0) {
                    $qtySum = Batch::query()
                        ->whereHas('stockEntry', function ($query) {
                            $query->where('branch_id', auth()->user()->branch_filter);
                        })
                        ->where('qty', '>', 0)
                        ->where('item_id', $drugMedDev->id)
                        ->orderBy('expired_date', 'asc')
                        ->sum('qty');

                    if ($qtySum < $value['qty']) {
                        // $this->notification = 'Pembayaran gagal disimpan, stok obat kurang';
                        // return;
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
                    // $this->notification = 'Pembayaran gagal disimpan, laborate harus diisi';
                    // return;
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
                    // $this->notification = 'Pembayaran gagal disimpan, laborate tidak ditemukan';
                    // return;
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Laborate tidak ditemukan',
                        'showConfirmButton' => true
                    ]);
                    return;
                }

                if ($value['qty'] == 0) {
                    // $this->notification = 'Pembayaran gagal disimpan, jumlah laborate harus diisi';
                    // return;
                    $this->alert('error', 'Pembayaran Gagal', [
                        'toast' => false,
                        'position' => 'center',
                        'text' => 'Jumlah laborate harus diisi',
                        'showConfirmButton' => true
                    ]);
                    return;
                }
            }

            $lastTransaction = Transaction::latest()->first();

            $transaction = new Transaction();
            if ($lastTransaction == null) {
                $transaction->transaction_number = 'INV.' . date('m') . '.' . '00001';
            } else {
                $transaction->transaction_number = 'INV.' . date('m') . '.' . str_pad((int)explode('.', $lastTransaction->transaction_number)[2] + 1, 5, "0", STR_PAD_LEFT);
            }
            $transaction->date = Carbon::parse($this->date)->toDateString();
            $transaction->medical_record_id = $medicalRecord?->id ?? null;
            $transaction->doctor_id = $medicalRecord?->doctor_id ?? $this->doctor_id > 0 ? $this->doctor_id : null;
            $transaction->patient_id = $this->user_id;
            $transaction->branch_id = auth()->user()->branch_filter;
            $transaction->poli_id = $this->poli_id ?? NULL;
            $transaction->estimated_arrival = $this->estimated_arrival;
            $transaction->save();

            $registration =  Registration::find($medicalRecord?->registration_id);
            if ($registration) {
                $registration->status = "Selesai";
                // $registration->queue_number = null;
                $registration->save();
            }

            $action = [];
            $drugMedDev = [];
            $laborate = [];
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
                    'discount' => $discount,
                    'price' => $value['price'],
                    'isPromo' => $value['isPromo']
                ];
            }

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
                            'document_reference' => $transaction->transaction_number,
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

                $drugMedDevCurrent = DrugMedDev::find($value['item_id']);
                $how_to_use = $medicalRecord ? $medicalRecord->drugMedDevs()->where('drug_med_dev_id', $value['item_id'])->first() : NULL;
                $drugMedDev[$value['item_id']] = [
                    'qty' => $value['qty'],
                    'discount' => $value['discount'],
                    'batch_id' => $batchId,
                    'how_to_use' => $how_to_use->pivot->how_to_use ?? $value['type'],
                    'rule' => $how_to_use->pivot->rule ?? $value['rule'],
                    'price' => $drugMedDevCurrent->selling_price,
                    'isPromo' => $value['isPromo']
                ];
            }

            foreach ($this->laborates as $value) {
                $laborate[$value['item_id']] = [
                    'qty' => $value['qty'],
                    'discount' => $value['discount'],
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

            $transaction->actions()->sync($action);
            $transaction->drugMedDevs()->sync($drugMedDev);
            $transaction->laborates()->sync($laborate);
            $transaction->paymentMethods()->sync($paymentMethods);

            DB::commit();
            Toaster::success('Pembayaran berhasil disimpan');
            return $this->redirectRoute('payment.show', [$transaction->uuid], navigate: true);
        } catch (\Throwable $th) {
            DB::rollback();
            $this->notification = 'Gagal simpan. Coba beberapa saat lagi' . $th;
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
