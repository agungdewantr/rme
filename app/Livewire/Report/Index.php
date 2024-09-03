<?php

namespace App\Livewire\Report;

use App\Exports\DoctorExport;
use App\Exports\IncomePerPatientExport;
use App\Exports\LabaRugiExport;
use App\Exports\ObatDanTindakanExport;
use App\Exports\ObatExport;
use App\Exports\PendapatanExport;
use App\Exports\PengeluaranExport;
use App\Exports\TindakanExport;
use App\Models\Branch;
use App\Models\CategoryOutcome;
use App\Models\DetailOutcome;
use App\Models\Outcome;
use App\Models\PaymentAction;
use App\Models\PaymentDrug;
use App\Models\Poli;
use App\Models\SipFee;
use App\Models\Transaction;
use App\Models\User;
use App\Policies\ReportPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{

    public $doctor_id;
    public $doctor;
    public $poli;
    public $branch_id;
    public $date = [];
    public $total_price;
    public $search;
    public $estimated_arrival;
    public $is_kumulatif = false;

    public $report_type_drug = 'Harian';
    public $type = 'Lap. Pendapatan';
    public $accumulative_drug = false;

    // 'Lap. per Dokter';

    public function mount()
    {
        if (request()->routeIs('report.clinic')) {
            $this->type = 'Lap. per Tindakan';
        }

        $this->branch_id = auth()->user()->branch_filter;
    }

    #[On('report-doctor-refresh')]
    public function refresh()
    {
    }

    public function updated($property, $value)
    {
        if ($property == 'date') {
            if (isset($value[0]) && isset($value[1])) {
                if (is_array($value)) {
                    $this->date = array_map(function ($val) {
                        return Carbon::parse($val)->setTimezone('Asia/Jakarta')->toDateString();
                    }, $value);
                }
            } elseif (isset($value[0]) && !isset($value[1])) {
                if (is_array($value)) {
                    $value[1] = $value[0];
                    $this->date = array_map(function ($val) {
                        return Carbon::parse($val)->setTimezone('Asia/Jakarta')->toDateString();
                    }, $value);
                }
            } else {
                $this->date = [];
            }
        }

        if ($property == 'is_kumulatif') {
            $this->report_type_drug = 'Bulanan';
        } else {
            $this->report_type_drug = 'Harian';

        }
    }

    public function export()
    {
        if ($this->type == 'Lap. per Dokter') {
            $transactions = Transaction::query()
            ->with(['medicalRecord.registration.branch', 'medicalRecord.doctor', 'actions'])
            ->has('medicalRecord.registration')
            ->when($this->doctor_id, function ($query) {
                return $query->whereHas('medicalRecord', function ($query) {
                    $query->where('doctor_id', $this->doctor_id);
                });
            })
            ->when($this->branch_id, function ($query) {
                return $query->whereHas('medicalRecord', function ($query) {
                    $query->whereHas('registration', function ($query) {
                        $query->where('branch_id', $this->branch_id);
                    });
                });
            })
            ->when($this->estimated_arrival, function ($query) {
                return $query->whereHas('medicalRecord', function ($query) {
                    $query->whereHas('registration', function ($query) {
                        $query->where('estimated_arrival', $this->estimated_arrival);
                    });
                });
            })
            ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                return $query->where('date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                    ->where('date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
            }, function ($query) {
                return $query->where('date', Carbon::now()->format('Y-m-d'));
            })
            ->get();


            $transactionsGrouped = $transactions->groupBy(function ($transaction) {
                $dateGroup = $this->is_kumulatif ? Carbon::parse($transaction->date)->format('Y-m') : $transaction->date;
                return $dateGroup . '_' . $transaction->medicalRecord->doctor->name .'_' . $transaction->medicalRecord->doctor->id . '_' . $transaction->medicalRecord->registration->branch->name . '_' . $transaction->medicalRecord->registration->poli;
            });

            $transactionGroupedAction = $transactionsGrouped->map(function ($group) {
                return $group->flatMap(function ($item) {
                    return $item->actions;
                })->groupBy(function ($action) {
                    return $action->id . '_' . $action->pivot->discount . '_' . $action->pivot->isPromo;
                });
            });


            $table = collect();
            foreach ($transactionGroupedAction as $groupKey => $actions) {
                [$date, $doctor, $doctor_id, $branch, $poli] = explode('_', $groupKey);

                foreach ($actions as $key => $groupedActions) {
                    [$actionId, $discount, $isPromo] = explode('_', $key);

                    $total_qty = $groupedActions->reduce(fn($c, $d) => $c + $d->pivot->qty, 0);
                    $action = $groupedActions->first();
                    $name = $action->name;

                    $fee = SipFee::where('action_id', $actionId)->first();

                    // Initialize the SIP and fee_doctor variables
                    $sip = null;
                    $fee_doctor = $fee->non_sip_fee ?? 0;

                    // Check if the doctor_id is present and retrieve the doctor's SIP information
                    if ($doctor_id) {
                        $healtWorkerDoctor = User::with('healthWorker')->where('id', $doctor_id)->first();
                        $sip = $healtWorkerDoctor->healthWorker->practice_license ?? null;

                        // Determine the doctor's fee based on the SIP
                        // $fee_doctor = $sip ? ($fee->sip_fee ?? 0) : ($fee->non_sip_fee ?? 0);
                        $fee_doctor = $action->pivot->doctor_fee ?? 0;
                    }

                    // Handle discount logic
                    if ($discount > 0) {
                        $name .= $isPromo ? '(Disc Promo)' : '(Disc)';
                        // if (!$isPromo) {
                        //     $fee_doctor = $fee_doctor * (($action->price - $discount)/ $action->price) ;
                        // }
                    }

                    // Add the row to the table
                    $table->push([
                        'date' => $date,
                        'doctor' => $doctor,
                        'branch' => $branch,
                        'poli' => $poli,
                        'name' => $name,
                        'qty' => $total_qty,
                        'price' => $fee_doctor,
                        'total' => $total_qty * $fee_doctor
                    ]);
                }
            }

            return Excel::download(new DoctorExport($table->sortBy('date'), $this->doctor_id, $this->date, $sip), 'Laporan-dokter.xlsx');
        } elseif ($this->type == 'Lap. Pendapatan') {
            $branch = filled($this->branch_id) ?  Branch::find($this->branch_id)->name : '-';
            $allTransactions = Transaction::query()
                ->with('medicalRecord', 'paymentMethods', 'actions', 'drugMedDevs', 'laborates', 'branch')
                ->when(filled($this->branch_id), function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->whereBetween(\DB::raw('DATE(date)'), [Carbon::parse($this->date[0])->format('Y-m-d'), Carbon::parse($this->date[1])->format('Y-m-d')]);
                })
                ->when(!isset($this->date[0]) && !isset($this->date[1]), function ($query) {
                    $query->whereBetween(\DB::raw('DATE(date)'), [
                        Carbon::now()->startOfMonth()->format('Y-m-d'),
                        Carbon::now()->format('Y-m-d')
                    ]);
                })
                ->when($this->estimated_arrival != null && $this->estimated_arrival != '', function ($query) {
                    $query->where('estimated_arrival', $this->estimated_arrival);
                })
                ->orderBy('date')
                ->get();

            // dump($allTransactions);

            $allDates = $allTransactions->pluck('date')->unique();
            $results = [];

            // akumulaif
            $accumulative = Transaction::query()
                ->with('medicalRecord', 'paymentMethods')
                ->when(filled($this->branch_id), function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })                ->where('medical_record_id', '<>', null)
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->where('date', '<', Carbon::parse($this->date[0])->format('Y-m-d'));
                })
                ->when(!isset($this->date[0]) && !isset($this->date[1]), function ($query) {
                    $query->where('date', '<', Carbon::now()->startOfMonth()->format('Y-m-d'));
                })
                ->get();

            // inject
            $acInject = Transaction::query()
                ->with('paymentMethods')
                ->when(filled($this->branch_id), function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })->where('medical_record_id', NULL)->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->where('date', '<=', $this->date[0])->where('date', '>=', '2024-06-30');
                }, function ($query) {
                    $query->where('date', '<=', Carbon::now()->startOfMonth()->format('Y-m-d'))->where('date', '>=', '2024-06-30');
                })->get();

            $acInjectId = $acInject->pluck('id')->toArray();

            // pengeluaran
            $ac_outcome_cash = Outcome::query()
                ->when($this->branch_id != null || $this->branch_id != '', function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->where('payment_method', 'Tunai')
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->where('date', '<', $this->date[0]);
                }, function ($query) {
                    $query->where('date', '<', Carbon::now()->startOfMonth()->format('Y-m-d'));
                })
                ->sum('nominal');

            $ac_cash = $accumulative->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount)))
                - $accumulative->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->change)))
                - $ac_outcome_cash;
            $ac_cash += $acInject->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount - $f->pivot->change)));

            foreach ($allDates as $date) {
                $transaction_mr = $allTransactions->where('date', $date)->filter(function ($transaction) {
                    return $transaction->medicalRecord !== null;
                });
                $transaction_ds = $allTransactions->where('date', $date)->filter(function ($transaction) {
                    return $transaction->medicalRecord === null;
                });
                $injectCashDuringTransaction = $allTransactions->where('date', $date)->filter(function ($transaction) {
                    return $transaction->medicalRecord === null;
                })->filter(function ($transaction) use ($acInjectId) {
                    return !in_array($transaction->id, $acInjectId) && $transaction->drugMedDevs->isEmpty();
                });

                $outcome_cash = Outcome::query()
                    ->when($this->branch_id != null || $this->branch_id != '', function ($query) {
                        $query->where('branch_id', $this->branch_id);
                    })
                    ->where('date', $date)
                    ->where('payment_method', 'Tunai')
                    ->sum('nominal');

                $total_ds = $transaction_ds->reduce(fn($c, $d) => $c + $d->drugMedDevs->reduce(fn($e, $f) => $e + ($f->selling_price * $f->pivot->qty) - $f->pivot->discount), 0);
                $total_injectCashDuringTransaction = $injectCashDuringTransaction->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount - $f->pivot->change)));
                $total_action = $transaction_mr->reduce(fn($c, $d) => $c + $d->actions->reduce(fn($e, $f) => $e + ($f->price * $f->pivot->qty) - $f->pivot->discount));
                $total_drug = $transaction_mr->reduce(fn($c, $d) => $c + $d->drugMedDevs->reduce(fn($e, $f) => $e + ($f->selling_price * $f->pivot->qty) - $f->pivot->discount));
                $total_laborate = $transaction_mr->reduce(fn($c, $d) => $c + $d->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty * $f->price) - $f->pivot->discount));
                $total_edc = $transaction_mr->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'EDC')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_transfer = $transaction_mr->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Transfer')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_qris = $transaction_mr->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'QRIS')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $cash = $transaction_mr->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));

                $cash += $transaction_ds->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_transfer += $transaction_ds->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Transfer')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_qris += $transaction_ds->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'QRIS')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_edc += $transaction_ds->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'EDC')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_cash = $cash - (($cash + $total_edc + $total_transfer + $total_qris) - ($total_drug + $total_action + $total_injectCashDuringTransaction + $total_ds + $total_laborate));


                $item = new \stdClass();
                $item->date = $date;
                $item->branch = $branch ?? '-';
                $item->total_action = $total_action;
                $item->total_laborate = $total_laborate;
                $item->total_drug = $total_drug + $total_ds;
                $item->total_cash = $total_cash;
                $item->total_edc = $total_edc;
                $item->total_transfer = $total_transfer;
                $item->total_qris = $total_qris;
                $item->accumulativeCash = $ac_cash += (($total_cash - $outcome_cash));
                $item->total_outcome_cash = $outcome_cash;

                $results[] = $item;
            }

            usort($results, function ($a, $b) {
                return strtotime($b->date) - strtotime($a->date);
            });

            return Excel::download(new PendapatanExport($results), 'Laporan-pendapatan.xlsx');
        } elseif ($this->type == 'Lap. per Tindakan') {
            $transactions = Transaction::query()
                ->with('medicalRecord.registration', 'actions', 'laborates')
                // ->has('laborates')
                ->when($this->poli, function ($query) {
                    return $query->whereHas('medicalRecord', function ($query) {
                        $query->whereHas('registration', function ($query) {
                            $query->where('poli', $this->poli);
                        });
                    });
                })
                ->when($this->branch_id, function ($query) {
                    return $query->whereHas('medicalRecord', function ($query) {
                        $query->whereHas('registration', function ($query) {
                            $query->where('branch_id', $this->branch_id);
                        });
                    });
                })
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    return $query->where('date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                        ->where('date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
                }, function ($query) {
                    return $query->where('date', Carbon::now()->format('Y-m-d'));
                })
                ->get();
            $transactionsGrouped = $transactions->groupBy(['date', 'medicalRecord.registration.poli'], true);
            $transactionGroupedAction = $transactionsGrouped->map(function ($group) {
                return $group->map(fn($item) => $item->pluck('actions')->flatten()->groupBy('id')->values());
            });
            $transactionsGroupedLaborate = $transactionsGrouped->map(function ($group) {
                return $group->map(fn($item) => $item->pluck('laborates')->flatten()->groupBy('id')->values());
            });

            // $laborates = $transactions->pluck('laborates')->flatten();
            // $total_laborates = $laborates->reduce(fn ($a, $b) => $a + $b->pivot->qty * $b->price - $b->pivot->discount, 0);

            // $this->total_price = $total_price + $total_laborates;
            $table = collect();
            foreach ($transactionGroupedAction as $date => $actionsValue) {
                foreach ($actionsValue as $poli => $actionValue) {
                    foreach ($actionValue as $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn($c, $d) => $c + $d->pivot->qty);
                            $name = $value[0]->name;
                            $price = $value[0]->price;
                            if ($value[0]->pivot->discount > 0) {
                                $name .= ' (Disc)';
                                $price -= $value[0]->pivot->discount;
                            }
                            $table->push([
                                'date' => $date,
                                'poli' => $poli,
                                'name' => $name,
                                'qty' => $total_qty,
                                'price' => $price,
                                'total' => $total_qty * $price
                            ]);
                        }
                    }
                }
            }
            foreach ($transactionsGroupedLaborate as $date => $laboratesValue) {
                foreach ($laboratesValue as $poli => $laborateValue) {
                    foreach ($laborateValue as $key => $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn($c, $d) => $c + $d->pivot->qty);
                            $name = $value[0]->name;
                            $price = $value[0]->price;
                            if ($value[0]->pivot->discount > 0) {
                                $name .= ' (Disc)';
                                $price -= $value[0]->pivot->discount;
                            }
                            $table->push([
                                'date' => $date,
                                'poli' => $poli,
                                'name' => $name,
                                'qty' => $total_qty,
                                'price' => $price,
                                'total' => $total_qty * $price
                            ]);
                        }
                    }
                }
            }

            $table = $table->sortBy('date');

            $this->total_price = $table->sum('total');

            return Excel::download(new TindakanExport($table, $this->total_price), 'Laporan-tindakan.xlsx');
        } elseif ($this->type == 'Lap. Obat') {
            $transaction = Transaction::query()
                ->leftJoin('polis', 'transactions.poli_id', '=', 'polis.id')
                ->leftJoin('payment_drugs', 'transactions.id', '=', 'payment_drugs.transaction_id')
                ->leftJoin('drug_med_devs', 'payment_drugs.drug_med_dev_id', '=', 'drug_med_devs.id')
                ->select(
                    'polis.name as poli',
                    'drug_med_devs.name as obat',
                    DB::raw('SUM(CAST(payment_drugs.qty AS DECIMAL)) as jumlah'),
                    DB::raw('CASE WHEN transactions.medical_record_id IS NULL THEN 1 ELSE 0 END as is_langsung'),
                    DB::raw('CASE WHEN payment_drugs.discount = \'0\' THEN 0 ELSE 1 END as is_discount'),
                    DB::raw('SUM((payment_drugs.price::DECIMAL - (payment_drugs.discount::DECIMAL / NULLIF(payment_drugs.qty::DECIMAL, 0))) * payment_drugs.qty::DECIMAL) as total'),
                    DB::raw('payment_drugs.price::DECIMAL - (payment_drugs.discount::DECIMAL / NULLIF(payment_drugs.qty::DECIMAL, 0)) as harga')
                )
                ->has('drugMedDevs')
                ->when(filled($this->poli), function ($query) {
                    $query->where('polis.name', $this->poli);
                })
                ->when(filled($this->branch_id), function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->when(filled($this->estimated_arrival), function ($query) {
                    $query->where('estimated_arrival', $this->estimated_arrival);
                })
                ->when($this->date != null && count($this->date) > 1, function ($query) {
                    $query->whereBetween('date', $this->date);
                }, function ($query) {
                    $query->whereBetween('date', [date('Y-m-01'), date('Y-m-t')]);
                })
                ->when($this->report_type_drug == 'Bulanan' || $this->is_kumulatif, function ($query) {
                    $query->addSelect(DB::raw('\'' . date('Y-m') . '\' as tanggal'))->groupBy(
                        'tanggal',
                        'polis.name',
                        'drug_med_devs.name',
                        'payment_drugs.price',
                        'payment_drugs.discount',
                        'payment_drugs.qty',
                        'is_discount',
                        'is_langsung'
                    );
                }, function ($query) {
                    $query->addSelect('transactions.date as tanggal')->orderBy('transactions.date')->groupBy(
                        'transactions.date',
                        'polis.name',
                        'drug_med_devs.name',
                        'payment_drugs.price',
                        'payment_drugs.discount',
                        'payment_drugs.qty',
                        'is_discount',
                        'is_langsung'
                    );
                })
                ->orderBy('drug_med_devs.name')
                ->get();
            // Generate Excel
            return Excel::download(new ObatExport($transaction, $this->report_type_drug, $this->is_kumulatif, $this->date), 'Laporan-obat.xlsx');
            $transaction = Transaction::query()
                ->has('medicalRecord')
                ->with('drugMedDevs', 'paymentMethods', 'actions', 'laborates', 'poli')
                ->when($this->estimated_arrival != null && $this->estimated_arrival != '', function ($query) {
                    $query->where('estimated_arrival', $this->estimated_arrival);
                })
                ->when($this->poli != null && $this->poli != '', function ($query) {
                    $query->whereHas('poli', function ($q) {
                        $q->where('name', $this->poli);
                    });
                })
                ->when($this->branch_id != null && $this->branch_id != '', function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->where('date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                        ->where('date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
                }, function ($query) {
                    $query->whereMonth('date', Carbon::now()->format('m'))->whereYear('date', Carbon::now()->format('Y'));
                })
                ->orderBy('date', 'desc')
                ->get();
            if ($this->report_type_drug == 'Bulanan') {
                $transactionGrouped = $transaction->groupBy([function ($item) {
                    return Carbon::parse($item->date)->format('Y-m');
                }, 'poli.name']);
            } else {
                $transactionGrouped = $transaction->groupBy([function ($item) {
                    return Carbon::parse($item->date)->format('Y-m-d');
                }, 'poli.name']);
            }

            if ($this->is_kumulatif) {
                $transactionGrouped = $transaction->groupBy([
                    function ($item) {
                        return Carbon::parse($item->date)->format('Y-m');
                    },
                    'poli.name'
                ], preserveKeys: true);
            }

            $transactionGroupedDrugMedDev = $transactionGrouped->map(function ($group) {
                return $group->map(function ($item) {
                    // Pastikan item adalah koleksi Laravel
                    return collect($item)->pluck('drugMedDevs')->flatten()->groupBy('id')->values();
                });
            });

            $table = collect();
            foreach ($transactionGroupedDrugMedDev as $date => $drugMedDevsValue) {
                foreach ($drugMedDevsValue as $poli => $drugMedDevValue) {
                    foreach ($drugMedDevValue as $key => $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $discountedItems) {
                            $total_qty = $discountedItems->reduce(function ($carry, $item) {
                                return $carry + $item->pivot->qty;
                            }, 0);
                            $name = $discountedItems[0]->name;
                            $price = $discountedItems[0]->pivot->price;
                            $total = $total_qty * $price;
                            if ($discountedItems[0]->pivot->discount > 0) {
                                $name .= ' (Disc)';
                                $total = $total_qty * $price - $discountedItems[0]->pivot->discount;
                            }
                            $table->push([
                                'date' => $date,
                                'poli' => $poli,
                                'name' => $name,
                                'qty' => $total_qty,
                                'price' => $price,
                                'total' => max(0, $total) // memastikan total tidak negatif
                            ]);
                        }
                    }
                }
            }
        } elseif ($this->type == 'Lap. Laba Rugi') {
            return Excel::download(new LabaRugiExport($this->date), 'Laporan-Laba-rugi.xlsx');
        } elseif ($this->type == 'Lap. Pengeluaran') {
            return Excel::download(new PengeluaranExport($this->date, $this->branch_id), 'Laporan_pengeluaran.xlsx');
        } elseif ($this->type == 'Lap. per Pasien') {
            $transactions = Transaction::query()
                ->with(['patient', 'doctor', 'drugMedDevs', 'laborates', 'actions', 'medicalRecord.registration', 'poli', 'branch'])
                ->when($this->branch_id != null, function ($query) {
                    $query->where('branch_id', $this->branch_id);
                    // $query->whereHas('medicalRecord', function ($query) {
                    //     $query->whereHas('registration', function ($query) {
                    //     });
                    // });
                })
                // ->where('date', empty($this->date[0]) && empty($this->date[1]) ?  $this->date : date('Y-m-d'))
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->whereBetween('date', $this->date);
                })
                ->when(!isset($this->date[0]) && !isset($this->date[1]), function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                })
                ->when($this->doctor_id, function ($query) {
                    $query->where('doctor_id', $this->doctor_id);
                })
                ->when($this->search, function ($query) {
                    $query->whereHas('patient', function ($query) {
                        $query->where('name', 'ilike', "%{$this->search}%");
                    });
                })
                ->get();


            return Excel::download(new IncomePerPatientExport($transactions), 'Lap. Pendapatan Per Pasien.xlsx');
        } elseif ($this->type == 'Lap. Obat dan Tindakan') {
            $transaction = Transaction::query()
                ->has('medicalRecord')
                ->with('drugMedDevs', 'paymentMethods', 'actions', 'laborates', 'poli')
                ->when($this->poli != null && $this->poli != '', function ($query) {
                    $query->whereHas('poli', function ($q) {
                        $q->where('name', $this->poli);
                    });
                })
                ->when($this->branch_id != null && $this->branch_id != '', function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->where('date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                        ->where('date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
                }, function ($query) {
                    $query->where('date', Carbon::today()->format('Y-m-d'));
                })
                ->get();

            $transactionGrouped = $transaction->groupBy(['date', 'poli.name']);
            $transactionGroupedDrugMedDev = $transactionGrouped->map(function ($group) {
                return $group->map(fn($item) => $item->pluck('drugMedDevs')->flatten()->groupBy('id')->values());
            });
            $transactionGroupedAction = $transactionGrouped->map(function ($group) {
                return $group->map(fn($item) => $item->pluck('actions')->flatten()->groupBy('id')->values());
            });
            $transactionGroupedLaborate = $transactionGrouped->map(function ($group) {
                return $group->map(fn($item) => $item->pluck('laborates')->flatten()->groupBy('id')->values());
            });

            $table = collect();
            foreach ($transactionGroupedDrugMedDev as $date => $drugMedDevsValue) {
                foreach ($drugMedDevsValue as $poli => $drugMedDevValue) {
                    foreach ($drugMedDevValue as $key => $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn($c, $d) => $c + $d->pivot->qty);
                            $name = $value[0]->name;
                            $price = $value[0]->pivot->price;
                            $total = $total_qty * $price;
                            if ($value[0]->pivot->discount > 0) {
                                $name .= ' (Disc)';
                                $total = ($total_qty * $price - $value[0]->pivot->discount); // $price -= $value[0]->pivot->discount;
                            }
                            $table->push([
                                'date' => $date,
                                'poli' => $poli,
                                'name' => $name,
                                'qty' => $total_qty,
                                'price' => $price,
                                'total' => $total
                            ]);
                        }
                    }
                }
            }
            foreach ($transactionGroupedAction as $date => $actionsValue) {
                foreach ($actionsValue as $poli => $actionValue) {
                    foreach ($actionValue as $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn($c, $d) => $c + $d->pivot->qty);
                            $name = $value[0]->name;
                            $price = $value[0]->price;
                            if ($value[0]->pivot->discount > 0) {
                                $name .= ' (Disc)';
                                $price -= $value[0]->pivot->discount;
                            }
                            $table->push([
                                'date' => $date,
                                'poli' => $poli,
                                'name' => $name,
                                'qty' => $total_qty,
                                'price' => $price,
                                'total' => $total_qty * $price
                            ]);
                        }
                    }
                }
            }
            foreach ($transactionGroupedLaborate as $date => $laboratesValue) {
                foreach ($laboratesValue as $poli => $laborateValue) {
                    foreach ($laborateValue as $key => $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn($c, $d) => $c + $d->pivot->qty);
                            $name = $value[0]->name;
                            $price = $value[0]->price;
                            if ($value[0]->pivot->discount > 0) {
                                $name .= ' (Disc)';
                                $price -= $value[0]->pivot->discount;
                            }
                            $table->push([
                                'date' => $date,
                                'poli' => $poli,
                                'name' => $name,
                                'qty' => $total_qty,
                                'price' => $price,
                                'total' => $total_qty * $price
                            ]);
                        }
                    }
                }
            }

            return Excel::download(new ObatDanTindakanExport($table->sortBy('date'), $table->sum('total')), 'Lap. Obat dan Tindakan.xlsx');
        }
    }


    public function render()
    {
        $this->authorize('report-read', ReportPolicy::class);
        $sip = null;
        if ($this->doctor_id == "") {
            $this->doctor_id = null;
        }
        if ($this->doctor_id) {
            $this->doctor = User::with('healthWorker')->where('id', $this->doctor_id)->first();
            $sip = $this->doctor->healthWorker->practice_license;
        } else {
            $this->doctor = null;
        }
        if ($this->type == 'Lap. per Dokter') {
        //     $transactions = Transaction::query()
        //     ->with(['medicalRecord.registration.branch', 'medicalRecord.registration', 'actions'])
        //     ->has('medicalRecord.registration')
        //     ->when($this->doctor_id, function ($query) {
        //         return $query->where('doctor_id', $this->doctor_id);
        //     })
        //     ->when($this->branch_id, function ($query) {
        //         return $query->whereHas('medicalRecord', function ($query) {
        //             $query->whereHas('registration', function ($query) {
        //                 $query->where('branch_id', $this->branch_id);
        //             });
        //         });
        //     })
        //     ->when($this->estimated_arrival, function ($query) {
        //         return $query->whereHas('medicalRecord', function ($query) {
        //             $query->whereHas('registration', function ($query) {
        //                 $query->where('estimated_arrival', $this->estimated_arrival);
        //             });
        //         });
        //     })
        //     ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
        //         return $query->where('date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
        //             ->where('date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
        //     }, function ($query) {
        //         return $query->where('date', Carbon::now()->format('Y-m-d'));
        //     })
        //     ->get();

        // $transactionsGrouped = $transactions->groupBy(function ($transaction) {
        //     return $transaction->medicalRecord->registration->branch->name . '_' . $transaction->medicalRecord->registration->poli;
        // });

        // $transactionGroupedAction = $transactionsGrouped->map(function ($group) {
        //     return $group->flatMap(function ($item) {
        //         return $item->actions;
        //     })->groupBy('id')->values();
        // });

        // $table = collect();
        // foreach ($transactionGroupedAction as $groupKey => $actionValue) {
        //     [$branch, $poli] = explode('_', $groupKey);

        //     foreach ($actionValue as $value) {
        //         $discountGroup = $value->groupBy('pivot.discount');
        //         foreach ($discountGroup as $groupedActions) {
        //             $total_qty = $groupedActions->reduce(fn($c, $d) => $c + $d->pivot->qty, 0);
        //             $action = $groupedActions->first();
        //             $name = $action->name;

        //             $fee = SipFee::where('action_id', $action->pivot->action_id)->first();
        //             if ($sip == null) {
        //                 $fee_doctor = $fee->non_sip_fee ?? 0;
        //             } else {
        //                 $fee_doctor = $fee->sip_fee ?? 0;
        //             }

        //             if ($action->pivot->discount > 0) {
        //                 $name .= $action->pivot->isPromo ? '(Disc Promo)' : '(Disc)';
        //                 if ($action->pivot->isPromo == false) {
        //                     $fee_doctor -= $action->pivot->discount;
        //                 }
        //             }

        //             $table->push([
        //                 'branch' => $branch,
        //                 'poli' => $poli,
        //                 'name' => $name,
        //                 'qty' => $total_qty,
        //                 'price' => $fee_doctor,
        //                 'total' => $total_qty * $fee_doctor
        //             ]);
        //         }
        //     }
        // }

    $transactions = Transaction::query()
    ->with(['medicalRecord.registration.branch', 'medicalRecord.doctor', 'actions'])
    ->has('medicalRecord.registration')
    ->when($this->doctor_id, function ($query) {
        return $query->whereHas('medicalRecord', function ($query) {
            $query->where('doctor_id', $this->doctor_id);
        });
    })
    ->when($this->branch_id, function ($query) {
        return $query->whereHas('medicalRecord', function ($query) {
            $query->whereHas('registration', function ($query) {
                $query->where('branch_id', $this->branch_id);
            });
        });
    })
    ->when($this->estimated_arrival, function ($query) {
        return $query->whereHas('medicalRecord', function ($query) {
            $query->whereHas('registration', function ($query) {
                $query->where('estimated_arrival', $this->estimated_arrival);
            });
        });
    })
    ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
        return $query->where('date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
            ->where('date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
    }, function ($query) {
        return $query->where('date', Carbon::now()->format('Y-m-d'));
    })
    ->get();


    $transactionsGrouped = $transactions->groupBy(function ($transaction) {
        $dateGroup = $this->is_kumulatif ? Carbon::parse($transaction->date)->format('Y-m') : $transaction->date;
        return $dateGroup . '_' . $transaction->medicalRecord->doctor->name .'_' . $transaction->medicalRecord->doctor->id . '_' . $transaction->medicalRecord->registration->branch->name . '_' . $transaction->medicalRecord->registration->poli;
    });

    $transactionGroupedAction = $transactionsGrouped->map(function ($group) {
        return $group->flatMap(function ($item) {
            return $item->actions;
        })->groupBy(function ($action) {
            return $action->id . '_' . $action->pivot->discount . '_' . $action->pivot->isPromo;
        });
    });


    $table = collect();
    foreach ($transactionGroupedAction as $groupKey => $actions) {
        [$date, $doctor, $doctor_id, $branch, $poli] = explode('_', $groupKey);

        foreach ($actions as $key => $groupedActions) {
            [$actionId, $discount, $isPromo] = explode('_', $key);

            $total_qty = $groupedActions->reduce(fn($c, $d) => $c + $d->pivot->qty, 0);
            $action = $groupedActions->first();
            $name = $action->name;

            $fee = SipFee::where('action_id', $actionId)->first();

            // Initialize the SIP and fee_doctor variables
            $sip = null;
            $fee_doctor = $fee->non_sip_fee ?? 0;

            // Check if the doctor_id is present and retrieve the doctor's SIP information
            if ($doctor_id) {
                $healtWorkerDoctor = User::with('healthWorker')->where('id', $doctor_id)->first();
                $sip = $healtWorkerDoctor->healthWorker->practice_license ?? null;

                // Determine the doctor's fee based on the SIP
                // $fee_doctor = $sip ? ($fee->sip_fee ?? 0) : ($fee->non_sip_fee ?? 0);
                $fee_doctor = $action->pivot->doctor_fee ?? 0;
            }

            // Handle discount logic
            if ($discount > 0) {
                $name .= $isPromo ? '(Disc Promo)' : '(Disc)';
                // if (!$isPromo) {
                //     $fee_doctor = $fee_doctor * (($action->price - $discount)/ $action->price) ;
                // }
            }

            // Add the row to the table
            $table->push([
                'date' => $date,
                'doctor' => $doctor,
                'branch' => $branch,
                'poli' => $poli,
                'name' => $name,
                'qty' => $total_qty,
                'price' => $fee_doctor,
                'total' => $total_qty * $fee_doctor
            ]);
        }
    }



            $branchTransactions = [];
            $branches = Branch::all(['id', 'name']);

            foreach ($branches as $b) {
                $branchTransactions[$b->name] = $table->filter(function ($item) use ($b) {
                    return $item['branch'] === $b->name;
                })->values()->all();
            }

            // Now, $table contains the data grouped by branch and poli

            return view('livewire.report.doctor', [
                'table' => $table,
                'branchTransactions' => $branchTransactions,
                'branches' => $branches,
                'doctors' => User::with('healthWorker')->whereHas('healthWorker', function ($query) {
                    $query->where('position', 'Dokter');
                })->get(),
                'sip' => $sip
            ]);
        } elseif ($this->type == 'Lap. Obat dan Tindakan') {
            $transaction = Transaction::query()
                ->has('medicalRecord')
                ->with('drugMedDevs', 'paymentMethods', 'actions', 'laborates', 'poli')
                ->when($this->estimated_arrival != null && $this->estimated_arrival != '', function ($query) {
                    $query->where('estimated_arrival', $this->estimated_arrival);
                })
                ->when($this->poli != null && $this->poli != '', function ($query) {
                    $query->whereHas('poli', function ($q) {
                        $q->where('name', $this->poli);
                    });
                })
                ->when($this->branch_id != null && $this->branch_id != '', function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->where('date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                        ->where('date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
                }, function ($query) {
                    $query->where('date', Carbon::today()->format('Y-m-d'));
                })
                ->get();

            $transactionGrouped = $transaction->groupBy(['date', 'poli.name']);
            $transactionGroupedDrugMedDev = $transactionGrouped->map(function ($group) {
                return $group->map(fn($item) => $item->pluck('drugMedDevs')->flatten()->groupBy('id')->values());
            });
            $transactionGroupedAction = $transactionGrouped->map(function ($group) {
                return $group->map(fn($item) => $item->pluck('actions')->flatten()->groupBy('id')->values());
            });
            $transactionGroupedLaborate = $transactionGrouped->map(function ($group) {
                return $group->map(fn($item) => $item->pluck('laborates')->flatten()->groupBy('id')->values());
            });

            $table = collect();
            foreach ($transactionGroupedDrugMedDev as $date => $drugMedDevsValue) {
                foreach ($drugMedDevsValue as $poli => $drugMedDevValue) {
                    foreach ($drugMedDevValue as $key => $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn($c, $d) => $c + $d->pivot->qty);
                            $name = $value[0]->name;
                            $price = $value[0]->pivot->price;
                            $total = $total_qty * $price;
                            if ($value[0]->pivot->discount > 0) {
                                $name .= ' (Disc)';
                                $total = ($total_qty * $price - $value[0]->pivot->discount); // $price -= $value[0]->pivot->discount;
                            }
                            $table->push([
                                'date' => $date,
                                'poli' => $poli,
                                'name' => $name,
                                'qty' => $total_qty,
                                'price' => $price,
                                'total' => $total
                            ]);
                        }
                    }
                }
            }
            foreach ($transactionGroupedAction as $date => $actionsValue) {
                foreach ($actionsValue as $poli => $actionValue) {
                    foreach ($actionValue as $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn($c, $d) => $c + $d->pivot->qty);
                            $name = $value[0]->name;
                            $price = $value[0]->price;
                            if ($value[0]->pivot->discount > 0) {
                                $name .= ' (Disc)';
                                $price -= $value[0]->pivot->discount;
                            }
                            $table->push([
                                'date' => $date,
                                'poli' => $poli,
                                'name' => $name,
                                'qty' => $total_qty,
                                'price' => $price,
                                'total' => $total_qty * $price
                            ]);
                        }
                    }
                }
            }
            foreach ($transactionGroupedLaborate as $date => $laboratesValue) {
                foreach ($laboratesValue as $poli => $laborateValue) {
                    foreach ($laborateValue as $key => $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn($c, $d) => $c + $d->pivot->qty);
                            $name = $value[0]->name;
                            $price = $value[0]->price;
                            if ($value[0]->pivot->discount > 0) {
                                $name .= ' (Disc)';
                                $price -= $value[0]->pivot->discount;
                            }
                            $table->push([
                                'date' => $date,
                                'poli' => $poli,
                                'name' => $name,
                                'qty' => $total_qty,
                                'price' => $price,
                                'total' => $total_qty * $price
                            ]);
                        }
                    }
                }
            }

            $this->total_price = $table->sum('total');

            return view('livewire.report.obat-dan-tindakan', [
                'table' => $table->sortBy('date'),
                'branches' => Branch::all(['id', 'name'])
            ]);
        } elseif ($this->type == 'Lap. per Tindakan') {
            $transactions = Transaction::query()
                ->with('medicalRecord.registration', 'actions', 'laborates')
                ->when($this->poli, function ($query) {
                    return $query->whereHas('medicalRecord', function ($query) {
                        $query->whereHas('registration', function ($query) {
                            $query->where('poli', $this->poli);
                        });
                    });
                })
                ->when($this->branch_id, function ($query) {
                    return $query->whereHas('medicalRecord', function ($query) {
                        $query->whereHas('registration', function ($query) {
                            $query->where('branch_id', $this->branch_id);
                        });
                    });
                })
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    return $query->where('date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                        ->where('date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
                }, function ($query) {
                    return $query->where('date', Carbon::now()->format('Y-m-d'));
                })
                ->get();

            $transactionsGrouped = $transactions->groupBy(['date', 'medicalRecord.registration.poli'], true);

            $table = collect();

            function processItems($items, $table, $date, $poli)
            {
                foreach ($items as $value) {
                    $discountGroup = $value->groupBy('pivot.discount');
                    foreach ($discountGroup as $value) {
                        $total_qty = $value->reduce(fn($c, $d) => $c + $d->pivot->qty);
                        $name = $value[0]->name;
                        $price = $value[0]->price;
                        if ($value[0]->pivot->discount > 0) {
                            $name .= ' (Disc)';
                            $price -= $value[0]->pivot->discount;
                        }
                        $data = [
                            'date' => $date,
                            'poli' => $poli,
                            'name' => $name,
                            'qty' => $total_qty,
                            'price' => $price,
                            'total' => $total_qty * $price
                        ];
                        $table->push($data);
                    }
                }
                return $table;
            }

            if ($this->is_kumulatif) {
                $currentMonthYear = Carbon::parse($this->date[0])->format('Y-m');
                $transactionGroupedAction = $transactions->pluck('actions')->flatten()->groupBy('id');
                $transactionGroupedLaborate = $transactions->pluck('laborates')->flatten()->groupBy('id');
                $poli = $transactions->first()->medicalRecord->registration->poli ?? 'N/A'; // Default to 'N/A' if poli is not found

                $table = processItems($transactionGroupedAction, $table, $currentMonthYear, $poli);
                $table = processItems($transactionGroupedLaborate, $table, $currentMonthYear, $poli);
            } else {
                $transactionGroupedAction = $transactionsGrouped->map(function ($group) {
                    return $group->map(fn($item) => $item->pluck('actions')->flatten()->groupBy('id')->values());
                });
                $transactionsGroupedLaborate = $transactionsGrouped->map(function ($group) {
                    return $group->map(fn($item) => $item->pluck('laborates')->flatten()->groupBy('id')->values());
                });

                foreach ($transactionGroupedAction as $date => $actionsValue) {
                    foreach ($actionsValue as $poli => $actionValue) {
                        $table = processItems($actionValue, $table, $date, $poli);
                    }
                }

                foreach ($transactionsGroupedLaborate as $date => $laboratesValue) {
                    foreach ($laboratesValue as $poli => $laborateValue) {
                        $table = processItems($laborateValue, $table, $date, $poli);
                    }
                }
            }

            // Return or use $table as needed

            $this->total_price = $table->sum('total');
            return view('livewire.report.per-tindakan2', [
                'table' => $table->sortBy('date'),
                'doctors' => User::with('healthWorker')->whereHas('healthWorker', function ($query) {
                    $query->where('position', 'Dokter');
                })->get(),
                'branches' => Branch::all()
            ]);
        } elseif ($this->type == 'Lap. Pendapatan') {
            $branch = filled($this->branch_id) ?  Branch::find($this->branch_id)->name : '-';
            $allTransactions = Transaction::query()
                ->with('medicalRecord', 'paymentMethods', 'actions', 'drugMedDevs', 'laborates', 'branch')
                ->when(filled($this->branch_id), function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->whereBetween(\DB::raw('DATE(date)'), [Carbon::parse($this->date[0])->format('Y-m-d'), Carbon::parse($this->date[1])->format('Y-m-d')]);
                })
                ->when(!isset($this->date[0]) && !isset($this->date[1]), function ($query) {
                    $query->whereBetween(\DB::raw('DATE(date)'), [
                        Carbon::now()->startOfMonth()->format('Y-m-d'),
                        Carbon::now()->format('Y-m-d')
                    ]);
                })
                ->when($this->estimated_arrival != null && $this->estimated_arrival != '', function ($query) {
                    $query->where('estimated_arrival', $this->estimated_arrival);
                })
                ->orderBy('date')
                ->get();

            // dump($allTransactions);

            $allDates = $allTransactions->pluck('date')->unique();
            $results = [];

            // akumulaif
            $accumulative = Transaction::query()
                ->with('medicalRecord', 'paymentMethods')
                ->when(filled($this->branch_id), function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->where('medical_record_id', '<>', null)
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->where('date', '<', Carbon::parse($this->date[0])->format('Y-m-d'));
                })
                ->when(!isset($this->date[0]) && !isset($this->date[1]), function ($query) {
                    $query->where('date', '<', Carbon::now()->startOfMonth()->format('Y-m-d'));
                })
                ->get();

            // inject
            $acInject = Transaction::query()
                ->with('paymentMethods')
                ->when(filled($this->branch_id), function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })->where('medical_record_id', NULL)->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->where('date', '<=', $this->date[0])->where('date', '>=', '2024-06-30');
                }, function ($query) {
                    $query->where('date', '<=', Carbon::now()->startOfMonth()->format('Y-m-d'))->where('date', '>=', '2024-06-30');
                })->get();

            $acInjectId = $acInject->pluck('id')->toArray();

            // pengeluaran
            $ac_outcome_cash = Outcome::query()
                ->when($this->branch_id != null || $this->branch_id != '', function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->where('payment_method', 'Tunai')
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->where('date', '<', $this->date[0]);
                }, function ($query) {
                    $query->where('date', '<', Carbon::now()->startOfMonth()->format('Y-m-d'));
                })
                ->sum('nominal');

            $ac_cash = $accumulative->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount)))
                - $accumulative->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->change)))
                - $ac_outcome_cash;
            $ac_cash += $acInject->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount - $f->pivot->change)));

            foreach ($allDates as $date) {
                $transaction_mr = $allTransactions->where('date', $date)->filter(function ($transaction) {
                    return $transaction->medicalRecord !== null;
                });
                $transaction_ds = $allTransactions->where('date', $date)->filter(function ($transaction) {
                    return $transaction->medicalRecord === null;
                });
                $injectCashDuringTransaction = $allTransactions->where('date', $date)->filter(function ($transaction) {
                    return $transaction->medicalRecord === null;
                })->filter(function ($transaction) use ($acInjectId) {
                    return !in_array($transaction->id, $acInjectId) && $transaction->drugMedDevs->isEmpty();
                });

                $outcome_cash = Outcome::query()
                    ->when($this->branch_id != null || $this->branch_id != '', function ($query) {
                        $query->where('branch_id', $this->branch_id);
                    })
                    ->where('date', $date)
                    ->where('payment_method', 'Tunai')
                    ->sum('nominal');

                $total_ds = $transaction_ds->reduce(fn($c, $d) => $c + $d->drugMedDevs->reduce(fn($e, $f) => $e + ($f->selling_price * $f->pivot->qty) - $f->pivot->discount), 0);
                $total_injectCashDuringTransaction = $injectCashDuringTransaction->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount - $f->pivot->change)));
                $total_action = $transaction_mr->reduce(fn($c, $d) => $c + $d->actions->reduce(fn($e, $f) => $e + ($f->price * $f->pivot->qty) - $f->pivot->discount));
                $total_drug = $transaction_mr->reduce(fn($c, $d) => $c + $d->drugMedDevs->reduce(fn($e, $f) => $e + ($f->selling_price * $f->pivot->qty) - $f->pivot->discount));
                $total_laborate = $transaction_mr->reduce(fn($c, $d) => $c + $d->laborates->reduce(fn($e, $f) => $e + ($f->pivot->qty * $f->price) - $f->pivot->discount));
                $total_edc = $transaction_mr->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'EDC')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_transfer = $transaction_mr->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Transfer')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_qris = $transaction_mr->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'QRIS')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $cash = $transaction_mr->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));

                $cash += $transaction_ds->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_transfer += $transaction_ds->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'Transfer')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_qris += $transaction_ds->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'QRIS')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_edc += $transaction_ds->reduce(fn($c, $d) => $c + $d->paymentMethods->where('name', 'EDC')->reduce(fn($e, $f) => $e + ($f->pivot->amount)));
                $total_cash = $cash - (($cash + $total_edc + $total_transfer + $total_qris) - ($total_drug + $total_action + $total_injectCashDuringTransaction + $total_ds + $total_laborate));


                $item = new \stdClass();
                $item->date = $date;
                $item->branch = $branch ?? '-';
                $item->total_action = $total_action;
                $item->total_laborate = $total_laborate;
                $item->total_drug = $total_drug + $total_ds;
                $item->total_cash = $total_cash;
                $item->total_edc = $total_edc;
                $item->total_transfer = $total_transfer;
                $item->total_qris = $total_qris;
                $item->accumulativeCash = $ac_cash += (($total_cash - $outcome_cash));
                $item->total_outcome_cash = $outcome_cash;

                $results[] = $item;
            }

            usort($results, function ($a, $b) {
                return strtotime($b->date) - strtotime($a->date);
            });

            return view('livewire.report.pendapatan2', [
                'reports' => $results,
                'branches' => Branch::where('is_active', true)->get(),
            ]);
        } elseif ($this->type == 'Lap. Obat') {
            $transaction = Transaction::query()
                ->leftJoin('polis', 'transactions.poli_id', '=', 'polis.id')
                ->leftJoin('payment_drugs', 'transactions.id', '=', 'payment_drugs.transaction_id')
                ->leftJoin('drug_med_devs', 'payment_drugs.drug_med_dev_id', '=', 'drug_med_devs.id')
                ->select(
                    'polis.name as poli',
                    'drug_med_devs.name as obat',
                    DB::raw('SUM(CAST(payment_drugs.qty AS DECIMAL)) as jumlah'),
                    DB::raw('CASE WHEN transactions.medical_record_id IS NULL THEN 1 ELSE 0 END as is_langsung'),
                    DB::raw('CASE WHEN payment_drugs.discount = \'0\' THEN 0 ELSE 1 END as is_discount'),
                    DB::raw('SUM((payment_drugs.price::DECIMAL - (payment_drugs.discount::DECIMAL / NULLIF(payment_drugs.qty::DECIMAL, 0))) * payment_drugs.qty::DECIMAL) as total'),
                    DB::raw('payment_drugs.price::DECIMAL - (payment_drugs.discount::DECIMAL / NULLIF(payment_drugs.qty::DECIMAL, 0)) as harga')
                )
                ->has('drugMedDevs')
                ->when(filled($this->poli), function ($query) {
                    $query->where('polis.name', $this->poli);
                })
                ->when(filled($this->branch_id), function ($query) {
                    $query->where('branch_id', $this->branch_id);
                })
                ->when(filled($this->estimated_arrival), function ($query) {
                    $query->where('estimated_arrival', $this->estimated_arrival);
                })
                ->when($this->date != null && count($this->date) > 1, function ($query) {
                    $query->whereBetween('date', $this->date);
                }, function ($query) {
                    $query->whereBetween('date', [date('Y-m-01'), date('Y-m-t')]);
                })
                ->when($this->report_type_drug == 'Bulanan' || $this->is_kumulatif, function ($query) {
                    $query->addSelect(DB::raw('\'' . date('Y-m') . '\' as tanggal'))->groupBy(
                        'tanggal',
                        'polis.name',
                        'drug_med_devs.name',
                        'payment_drugs.price',
                        'payment_drugs.discount',
                        'payment_drugs.qty',
                        'is_discount',
                        'is_langsung'
                    );
                }, function ($query) {
                    $query->addSelect('transactions.date as tanggal')->orderBy('transactions.date')->groupBy(
                        'transactions.date',
                        'polis.name',
                        'drug_med_devs.name',
                        'payment_drugs.price',
                        'payment_drugs.discount',
                        'payment_drugs.qty',
                        'is_discount',
                        'is_langsung'
                    );
                })
                ->orderBy('drug_med_devs.name')
                ->get();

            return view('livewire.report.drug', [
                'table' => $transaction,
                'branches' => Branch::all(),
                'polis' => Poli::query()
                    ->where('is_active', true)
                    ->get()
            ]);

            // dd($transaction->pluck('date'));
            // $transaction = Transaction::query()
            //     ->has('medicalRecord')
            //     ->with('drugMedDevs', 'paymentMethods', 'actions', 'laborates', 'poli')
            //     ->when($this->estimated_arrival != null && $this->estimated_arrival != '', function ($query) {
            //         $query->where('estimated_arrival', $this->estimated_arrival);
            //     })
            //     ->when($this->poli != null && $this->poli != '', function ($query) {
            //         $query->whereHas('poli', function ($q) {
            //             $q->where('name', $this->poli);
            //         });
            //     })
            //     ->when($this->branch_id != null && $this->branch_id != '', function ($query) {
            //         $query->where('branch_id', $this->branch_id);
            //     })
            //     ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
            //         $query->where('date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
            //             ->where('date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
            //     }, function ($query) {
            //         $query->whereMonth('date', Carbon::now()->format('m'))->whereYear('date', Carbon::now()->format('Y'));
            //     })
            //     ->orderBy('date', 'desc')
            //     ->get();
            // if ($this->report_type_drug == 'Bulanan') {
            //     $transactionGrouped = $transaction->groupBy([function ($item) {
            //         return Carbon::parse($item->date)->format('Y-m');
            //     }, 'poli.name']);
            // } else {
            //     $transactionGrouped = $transaction->groupBy([function ($item) {
            //         return Carbon::parse($item->date)->format('Y-m-d');
            //     }, 'poli.name']);
            // }

            if ($this->is_kumulatif) {
                $this->report_type_drug = 'Bulanan';
                $transactionGrouped = $transaction->groupBy([
                    function ($item) {
                        return Carbon::parse($item->date)->format('Y-m');
                    },
                    'poli.name'
                ], preserveKeys: true);
            }

            // $transactionGroupedDrugMedDev = $transactionGrouped->map(function ($group) {
            //     return $group->map(function ($item) {
            //         // Pastikan item adalah koleksi Laravel
            //         return collect($item)->pluck('drugMedDevs')->flatten()->groupBy('id')->values();
            //     });
            // });

            // $table = collect();
            // foreach ($transactionGroupedDrugMedDev as $date => $drugMedDevsValue) {
            //     foreach ($drugMedDevsValue as $poli => $drugMedDevValue) {
            //         foreach ($drugMedDevValue as $key => $value) {
            //             $discountGroup = $value->groupBy('pivot.discount');
            //             foreach ($discountGroup as $discountedItems) {
            //                 $total_qty = $discountedItems->reduce(function ($carry, $item) {
            //                     return $carry + $item->pivot->qty;
            //                 }, 0);
            //                 $name = $discountedItems[0]->name;
            //                 $price = $discountedItems[0]->pivot->price;
            //                 $total = $total_qty * $price;
            //                 if ($discountedItems[0]->pivot->discount > 0) {
            //                     $name .= ' (Disc)';
            //                     $total = $total_qty * $price - $discountedItems[0]->pivot->discount;
            //                 }
            //                 $table->push([
            //                     'date' => $date,
            //                     'poli' => $poli,
            //                     'name' => $name,
            //                     'qty' => $total_qty,
            //                     'price' => $price,
            //                     'total' => max(0, $total) // memastikan total tidak negatif
            //                 ]);
            //             }
            //         }
            //     }
            // }

        } elseif ($this->type == 'Lap. Laba Rugi') {
            $outcome = DetailOutcome::select(\DB::raw('COALESCE(SUM(CAST(outcomes.nominal AS INTEGER)), 0) as total'), 'accounts.name')
                ->join('outcomes', 'outcomes.id', '=', 'detail_outcomes.outcomes_id')
                ->join('accounts', 'outcomes.account_id', '=', 'accounts.id');

            $income_action = PaymentAction::join('actions', 'actions.id', '=', 'payment_actions.action_id')
                ->join('transactions', 'transactions.id', '=', 'payment_actions.transaction_id')
                ->select(\DB::raw('COALESCE(SUM(CAST(payment_actions.qty AS INTEGER) * CAST(actions.price AS INTEGER)), 0) as grand_total'));

            $income_drug = PaymentDrug::join('drug_med_devs', 'drug_med_devs.id', '=', 'payment_drugs.drug_med_dev_id')
                ->join('transactions', 'payment_drugs.transaction_id', 'transactions.id')
                ->select(\DB::raw('COALESCE(SUM(CAST(payment_drugs.qty AS INTEGER) * CAST(drug_med_devs.selling_price AS INTEGER)), 0) as grand_total'));

            $outcome_drug = PaymentDrug::join('drug_med_devs', 'drug_med_devs.id', '=', 'payment_drugs.drug_med_dev_id')
                ->join('transactions', 'payment_drugs.transaction_id', 'transactions.id')
                ->select(\DB::raw('COALESCE(SUM(CAST(payment_drugs.qty AS INTEGER) * CAST(drug_med_devs.purchase_price AS INTEGER)), 0) as grand_total'));

            if ($this->date) {
                $outcome = $outcome->whereMonth('outcomes.date', '=', Carbon::parse($this->date[0])->format('m'))
                    ->whereYear('outcomes.date', '=', Carbon::parse($this->date[0])->format('Y'));
                $income_action = $income_action->whereMonth('transactions.date', '=', Carbon::parse($this->date[0])->format('m'))
                    ->whereYear('transactions.date', '=', Carbon::parse($this->date[0])->format('Y'));
                $income_drug = $income_drug->whereMonth('transactions.date', '=', Carbon::parse($this->date[0])->format('m'))
                    ->whereYear('transactions.date', '=', Carbon::parse($this->date[0])->format('Y'));
                $outcome_drug = $outcome_drug->whereMonth('transactions.date', '=', Carbon::parse($this->date[0])->format('m'))
                    ->whereYear('transactions.date', '=', Carbon::parse($this->date[0])->format('Y'));
            } else {
                $outcome = $outcome->whereMonth('outcomes.date', '=', Carbon::parse(now())->format('m'))
                    ->whereYear('outcomes.date', '=', Carbon::parse(now())->format('Y'));
                $income_action = $income_action->whereMonth('transactions.date', '=', Carbon::parse(now())->format('m'))
                    ->whereYear('transactions.date', '=', Carbon::parse(now())->format('Y'));
                $income_drug = $income_drug->whereMonth('transactions.date', '=', Carbon::parse(now())->format('m'))
                    ->whereYear('transactions.date', '=', Carbon::parse(now())->format('Y'));
                $outcome_drug = $outcome_drug->whereMonth('transactions.date', '=', Carbon::parse(now())->format('m'))
                    ->whereYear('transactions.date', '=', Carbon::parse(now())->format('Y'));
            }

            $outcome = $outcome->groupBy('accounts.name')->get();
            $income_action = $income_action->value('grand_total');
            $income_drug = $income_drug->value('grand_total');
            $outcome_drug = $outcome_drug->value('grand_total');


            return view('livewire.report.laba-rugi', [
                'outcome' => $outcome,
                'income_action' => $income_action,
                'income_drug' => $income_drug,
                'outcome_drug' => $outcome_drug

            ]);
        } elseif ($this->type == 'Lap. Pengeluaran') {
            $categories = CategoryOutcome::select('name')
                ->distinct()
                ->pluck('name');

            $dynamicColumns = $categories->map(function ($category) {
                $columnName = str_replace([' ', '&', '@', '#', '$', '%', '^', '*', '(', ')'], '_', strtolower($category)) . '_total';
                return DB::raw("COALESCE(SUM(CASE WHEN outcomes.category = '$category' THEN CAST(outcomes.nominal AS INTEGER) ELSE 0 END), 0) as \"$columnName\"");
            });

            $totalNominal = DB::raw('COALESCE(SUM(' . $categories->map(function ($category) {
                    return "CASE WHEN outcomes.category = '$category' THEN CAST(outcomes.nominal AS INTEGER) ELSE 0 END";
                })->implode(' + ') . '), 0) as total_nominal');


            $query = Outcome::join('branches', 'outcomes.branch_id', '=', 'branches.id')
                ->select(array_merge(
                    [
                        'outcomes.date',
                        'branches.name as branch_name'
                    ],
                    $dynamicColumns->toArray(),
                    [$totalNominal]
                ));
            if (isset($this->date[0]) && isset($this->date[1])) {
                $query->where('outcomes.date', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                    ->where('outcomes.date', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
            } else {
                $query->whereMonth('outcomes.date', Carbon::now()->format('m'));
            }
            if ($this->branch_id != null) {
                $query = $query->where('outcomes.branch_id', $this->branch_id);
            }
            $outcome = $query->groupBy('outcomes.date', 'branches.name')
                ->orderBy('outcomes.date', 'desc')
                ->get();

            $categoryOutcomes = CategoryOutcome::all();

            return view('livewire.report.pengeluaran', [
                'outcome' => $outcome,
                'categoryOutcomes' => $categoryOutcomes,
                'branches' => Branch::where('is_active', true)->get()

            ]);
        } elseif ($this->type == 'Lap. per Pasien') {
            $transactions = Transaction::query()
                ->with(['patient', 'doctor', 'drugMedDevs', 'laborates', 'actions', 'medicalRecord.registration', 'poli', 'branch'])
                ->when($this->branch_id != null, function ($query) {
                    $query->where('branch_id', $this->branch_id);
                    // $query->whereHas('medicalRecord', function ($query) {
                    //     $query->whereHas('registration', function ($query) {
                    //     });
                    // });
                })
                // ->where('date', empty($this->date[0]) && empty($this->date[1]) ?  $this->date : date('Y-m-d'))
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->whereBetween('date', $this->date);
                })
                ->when(!isset($this->date[0]) && !isset($this->date[1]), function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                })
                ->when($this->doctor_id, function ($query) {
                    $query->where('doctor_id', $this->doctor_id);
                })
                ->when($this->search, function ($query) {
                    $query->whereHas('patient', function ($query) {
                        $query->where('name', 'ilike', "%{$this->search}%");
                    });
                })
                ->get();

                $transactionsByDoctor = $transactions->groupBy('doctor_id')->map(function ($group) {
                    return [
                        'doctor_name' => $group->first()->doctor->name ?? NULL,
                        'total_transactions' => $group->count(),
                    ];
                });

            return view('livewire.report.income-patient', [
                // 'branch_id' => auth()->user()->branch_filter,
                'transactions' => $transactions,
                'transactionsByDoctor' => $transactionsByDoctor,
                'doctors' => User::whereHas('healthWorker', function ($query) {
                    $query->where('position', 'Dokter');
                })->get(),
                'branches' => Branch::where('is_active', true)->get()
            ]);
        }
    }

    public function report_type($type)
    {
        $this->type = $type;
        $this->date = null;
        $this->doctor_id = null;
        $this->poli = null;
        $this->dispatch('report-doctor-refresh');
    }
}
