<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Branch;
use App\Models\CategoryOutcome;
use App\Models\DetailOutcome;
use App\Models\DrugMedDev;
use App\Models\FirstEntry;
use App\Models\Outcome;
use App\Models\Patient;
use App\Models\PaymentAction;
use App\Models\PaymentDrug;
use App\Models\Registration;
use App\Models\SipFee;
use App\Models\StockLedger;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function print_firstEntry(FirstEntry $firstEntry)
    {
        $firstEntry->load('patient', 'patient.job');
        $datetime1 = new DateTime($firstEntry->patient->dob);
        $datetime2 = new DateTime();
        $age_patient = $datetime1->diff($datetime2);

        $datetime1 = new DateTime($firstEntry->patient->husbands_birth_date);
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);
        return view('livewire.first-entry.print', compact('firstEntry', 'age_patient', 'age_husband'));
        // $pdf = Pdf::loadView('livewire.first-entry.print', compact('firstEntry'))->setPaper('a4', 'potrait');
        // return $pdf->stream('Asesmen Awal_'.$firstEntry->patient->patient_number.'.pdf');

    }

    public function print_patient(Patient $patient)
    {
        $patient->load(['firstEntry' => function ($query) {
            $query->latest()->first();
        }]);
        $datetime1 = new DateTime($patient->dob);
        $datetime2 = new DateTime();
        $age_patient = $datetime1->diff($datetime2);

        $datetime1 = new DateTime($patient->husbands_birth_date);
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);
        return view('livewire.patient.print', compact('patient', 'age_patient', 'age_husband'));
        // $pdf = Pdf::loadView('livewire.first-entry.print', compact('firstEntry'))->setPaper('a4', 'potrait');
        // return $pdf->stream('Asesmen Awal_'.$firstEntry->patient->patient_number.'.pdf');

    }

    public function print_report(Request $request)
    {
        $isDownload = $request->isDownload;
        $doctor = null;
        $poli = null;
        $sip = null;
        $branch = null;
        if ($request->doctor) {
            $doctor = User::with('healthWorker')->where('id', $request->doctor)->first();
            $sip = $doctor->healthWorker->practice_license;
        }
        if ($request->poli) {
            $poli = $request->poli;
        }
        if ($request->branch) {
            $branch = Branch::find($request->branch);
            $branch = $branch->name ?? null;
        }
        $date = $request->date ?? null;
        if ($request->type == 'Lap. per Dokter') {
            $dateRange = $date;
            $doctorFiltered = $doctor;
            $transactions = Transaction::query()
            ->with(['medicalRecord.registration.branch', 'medicalRecord.doctor', 'actions'])
            ->has('medicalRecord.registration')
            ->when($request->doctor, function ($query) use ($request)  {
                return $query->whereHas('medicalRecord', function ($query) use ($request) {
                    $query->where('doctor_id', $request->doctor);
                });
            })
            ->when($request->branch, function ($query) use ($request)  {
                return $query->whereHas('medicalRecord', function ($query) use ($request)    {
                    $query->whereHas('registration', function ($query) use ($request)  {
                        $query->where('branch_id', $request->branch);
                    });
                });
            })
            ->when($request->estimated_arrival, function ($query) use ($request)  {
                return $query->whereHas('medicalRecord', function ($query) use ($request)  {
                    $query->whereHas('registration', function ($query) use ($request)  {
                        $query->where('estimated_arrival', $request->estimated_arrival);
                    });
                });
            })
            ->when(isset($request->date[0]) && isset($request->date[1]), function ($query) use ($request)  {
                return $query->where('date', '>=', Carbon::parse($request->date[0])->format('Y-m-d'))
                    ->where('date', '<=', Carbon::parse($request->date[1])->format('Y-m-d'));
            }, function ($query) {
                return $query->where('date', Carbon::now()->format('Y-m-d'));
            })
            ->get();


            $transactionsGrouped = $transactions->groupBy(function ($transaction) use ($request) {
                $dateGroup = $request->iskumulatif ? Carbon::parse($transaction->date)->format('Y-m') : $transaction->date;
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
            [$date, $doctor, $doctor, $branch, $poli] = explode('_', $groupKey);

            foreach ($actions as $key => $groupedActions) {
                [$actionId, $discount, $isPromo] = explode('_', $key);

                $total_qty = $groupedActions->reduce(fn($c, $d) => $c + $d->pivot->qty, 0);
                $action = $groupedActions->first();
                $name = $action->name;

                $fee = SipFee::where('action_id', $actionId)->first();

                // Initialize the SIP and fee_doctor variables
                $sip = null;
                $fee_doctor = $fee->non_sip_fee ?? 0;

                // Check if the doctor is present and retrieve the doctor's SIP information
                if ($doctor) {
                    $healtWorkerDoctor = User::with('healthWorker')->where('id', $doctor)->first();
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

            return view('livewire.report.print-doctor', compact('table', 'doctorFiltered', 'dateRange', 'sip', 'isDownload'));
        } elseif ($request->type == 'Lap. Pendapatan') {
            $branch = Branch::find($request->branch)->name ?? '-';
            $allTransactions = Transaction::query()
                ->with('medicalRecord', 'paymentMethods', 'actions', 'drugMedDevs', 'laborates', 'branch')
                ->when(filled($request->branch), function ($query) use ($request) {
                    $query->where('branch_id', $request->branch);
                })
                ->when(isset($request->date[0]) && isset($request->date[1]), function ($query) use ($request) {
                    $query->whereBetween(\DB::raw('DATE(date)'), [Carbon::parse($request->date[0])->format('Y-m-d'), Carbon::parse($request->date[1])->format('Y-m-d')]);
                })
                ->when(!isset($request->date[0]) && !isset($request->date[1]), function ($query) {
                    $query->whereBetween(\DB::raw('DATE(date)'), [
                        Carbon::now()->startOfMonth()->format('Y-m-d'),
                        Carbon::now()->format('Y-m-d')
                    ]);
                })
                ->when($request->estimated_arrival != null && $request->estimated_arrival != '', function ($query) use ($request) {
                    $query->where('estimated_arrival', $request->estimated_arrival);
                })
                ->orderBy('date')
                ->get();

            // dump($allTransactions);

            $allDates = $allTransactions->pluck('date')->unique();
            $results = [];

            // akumulaif
            $accumulative = Transaction::query()
                ->with('medicalRecord', 'paymentMethods')
                ->when(filled($request->branch), function ($query) use ($request) {
                    $query->where('branch_id', $request->branch);
                })
                ->where('medical_record_id', '<>', null)
                ->when(isset($request->date[0]) && isset($request->date[1]), function ($query) use ($request) {
                    $query->where('date', '<', Carbon::parse($request->date[0])->format('Y-m-d'));
                })
                ->when(!isset($request->date[0]) && !isset($request->date[1]), function ($query) {
                    $query->where('date', '<', Carbon::now()->startOfMonth()->format('Y-m-d'));
                })
                ->get();

            // inject
            $acInject = Transaction::query()
                ->with('paymentMethods')
                ->when(filled($request->branch), function ($query) use ($request) {
                    $query->where('branch_id', $request->branch);
                })->where('medical_record_id', NULL)->when(isset($request->date[0]) && isset($request->date[1]), function ($query) use ($request) {
                    $query->where('date', '<=', $request->date[0])->where('date', '>=', '2024-06-30');
                }, function ($query) {
                    $query->where('date', '<=', Carbon::now()->startOfMonth()->format('Y-m-d'))->where('date', '>=', '2024-06-30');
                })->get();

            $acInjectId = $acInject->pluck('id')->toArray();

            // pengeluaran
            $ac_outcome_cash = Outcome::query()
                ->when($request->branch != null || $request->branch != '', function ($query) use ($request) {
                    $query->where('branch_id', $request->branch);
                })
                ->where('payment_method', 'Tunai')
                ->when(isset($request->date[0]) && isset($request->date[1]), function ($query) use ($request) {
                    $query->where('date', '<', $request->date[0]);
                }, function ($query) {
                    $query->where('date', '<', Carbon::now()->startOfMonth()->format('Y-m-d'));
                })
                ->sum('nominal');

            $ac_cash = $accumulative->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn ($e, $f) => $e + ($f->pivot->amount)))
                - $accumulative->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn ($e, $f) => $e + ($f->pivot->change)))
                - $ac_outcome_cash;
            $ac_cash += $acInject->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn ($e, $f) => $e + ($f->pivot->amount - $f->pivot->change)));

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
                    ->when($request->branch != null || $request->branch != '', function ($query) use ($request) {
                        $query->where('branch_id', $request->branch);
                    })
                    ->where('date', $date)
                    ->where('payment_method', 'Tunai')
                    ->sum('nominal');

                $total_ds = $transaction_ds->reduce(fn ($c, $d) => $c + $d->drugMedDevs->reduce(fn ($e, $f) => $e + ($f->selling_price * $f->pivot->qty) - $f->pivot->discount), 0);
                $total_injectCashDuringTransaction =  $injectCashDuringTransaction->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn ($e, $f) => $e + ($f->pivot->amount - $f->pivot->change)));
                $total_action = $transaction_mr->reduce(fn ($c, $d) => $c + $d->actions->reduce(fn ($e, $f) => $e + ($f->price * $f->pivot->qty) - $f->pivot->discount));
                $total_drug = $transaction_mr->reduce(fn ($c, $d) => $c + $d->drugMedDevs->reduce(fn ($e, $f) => $e + ($f->selling_price * $f->pivot->qty) - $f->pivot->discount));
                $total_laborate = $transaction_mr->reduce(fn ($c, $d) => $c + $d->laborates->reduce(fn ($e, $f) => $e + ($f->pivot->qty * $f->price) - $f->pivot->discount));
                $total_edc = $transaction_mr->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'EDC')->reduce(fn ($e, $f) => $e + ($f->pivot->amount)));
                $total_transfer = $transaction_mr->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'Transfer')->reduce(fn ($e, $f) => $e + ($f->pivot->amount)));
                $total_qris = $transaction_mr->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'QRIS')->reduce(fn ($e, $f) => $e + ($f->pivot->amount)));
                $cash = $transaction_mr->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn ($e, $f) => $e + ($f->pivot->amount)));

                $cash += $transaction_ds->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'Cash')->reduce(fn ($e, $f) => $e + ($f->pivot->amount)));
                $total_transfer += $transaction_ds->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'Transfer')->reduce(fn ($e, $f) => $e + ($f->pivot->amount)));
                $total_qris += $transaction_ds->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'QRIS')->reduce(fn ($e, $f) => $e + ($f->pivot->amount)));
                $total_edc += $transaction_ds->reduce(fn ($c, $d) => $c + $d->paymentMethods->where('name', 'EDC')->reduce(fn ($e, $f) => $e + ($f->pivot->amount)));
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


            return view('livewire.report.print-pendapatan', compact('results', 'isDownload'));
        } elseif ($request->type == 'Lap. per Tindakan') {
            $transactions = Transaction::query()
                ->with('medicalRecord.registration', 'actions', 'laborates')
                // ->has('laborates')
                ->when($request->poli, function ($query) use ($request) {
                    return $query->whereHas('medicalRecord', function ($query) use ($request) {
                        $query->whereHas('registration', function ($query) use ($request) {
                            $query->where('poli', $request->poli);
                        });
                    });
                })
                ->when($request->branch, function ($query) use ($request) {
                    return $query->whereHas('medicalRecord', function ($query) use ($request) {
                        $query->whereHas('registration', function ($query) use ($request) {
                            $query->where('branch_id', $request->branch);
                        });
                    });
                })
                ->when(isset($request->date[0]) && isset($request->date[1]), function ($query) use ($request) {
                    return $query->where('date', '>=', Carbon::parse($request->date[0])->format('Y-m-d'))
                        ->where('date', '<=', Carbon::parse($request->date[1])->format('Y-m-d'));
                }, function ($query) {
                    return $query->where('date', Carbon::now()->format('Y-m-d'));
                })
                ->get();
            $transactionsGrouped = $transactions->groupBy(['date', 'medicalRecord.registration.poli'], true);
            $transactionGroupedAction = $transactionsGrouped->map(function ($group) {
                return $group->map(fn ($item) => $item->pluck('actions')->flatten()->groupBy('id')->values());
            });
            $transactionsGroupedLaborate = $transactionsGrouped->map(function ($group) {
                return $group->map(fn ($item) => $item->pluck('laborates')->flatten()->groupBy('id')->values());
            });
            $table = collect();
            foreach ($transactionGroupedAction as $date => $actionsValue) {
                foreach ($actionsValue as $poli => $actionValue) {
                    foreach ($actionValue as $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn ($c, $d) => $c + $d->pivot->qty);
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
                            $total_qty = $value->reduce(fn ($c, $d) => $c + $d->pivot->qty);
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
            return view('livewire.report.print-pertindakan', compact('table', 'isDownload'));
        } elseif ($request->type == 'Lap. Obat') {
            $report_type_drug = $request->reporttypedrug ?? 'Harian';
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
            ->when(filled($request->poli), function ($query) use ($request) {
                $query->where('polis.name', $request->poli);
            })
            ->when(filled($request->branch), function ($query) use ($request) {
                $query->where('branch_id', $request->branch);
            })
            ->when(filled($request->estimated_arrival), function ($query) use ($request){
                $query->where('estimated_arrival', $request->estimated_arrival);
            })
            ->when($request->date != null && count($request->date) > 1, function ($query) use ($request) {
                $query->whereBetween('date', $request->date);
            }, function ($query) {
                $query->whereBetween('date', [date('Y-m-01'), date('Y-m-t')]);
            })
            ->when($request->report_type_drug == 'Bulanan' || $request->iskumulatif, function ($query) {
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


            return view('livewire.report.print-obat', compact('transaction', 'date', 'report_type_drug', 'poli', 'isDownload'));
        } elseif ($request->type == 'Lap. Pengeluaran') {
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


            $query = Outcome::join('branches', 'outcomes.branch', '=', 'branches.id')
                ->select(array_merge(
                    [
                        'outcomes.date',
                        'branches.name as branch_name'
                    ],
                    $dynamicColumns->toArray(),
                    [$totalNominal]
                ));

            if (isset($request->date[0]) && isset($request->date[1])) {
                $query->where('outcomes.date', '>=', Carbon::parse($request->date[0])->format('Y-m-d'))
                    ->where('outcomes.date', '<=', Carbon::parse($request->date[1])->format('Y-m-d'));
            } else {
                $query->whereMonth('outcomes.date', Carbon::now()->format('m'));
            }
            if ($request->branch != null) {
                $query = $query->where('outcomes.branch', $request->branch);
            }
            $outcome = $query->groupBy('outcomes.date', 'branches.name')
                ->orderBy('outcomes.date', 'desc')
                ->get();
            $categoryOutcomes = CategoryOutcome::all();
            return view('livewire.report.print-pengeluaran', compact('outcome', 'date', 'branch', 'isDownload', 'categoryOutcomes'));
        } elseif ($request->type == 'Lap. Laba Rugi') {
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


            if ($request->date) {
                $outcome = $outcome->whereMonth('outcomes.date', '=', Carbon::parse($request->date[0])->format('m'))
                    ->whereYear('outcomes.date', '=', Carbon::parse($request->date[0])->format('Y'));
                $income_action = $income_action->whereMonth('transactions.date', '=', Carbon::parse($request->date[0])->format('m'))
                    ->whereYear('transactions.date', '=', Carbon::parse($request->date[0])->format('Y'));
                $income_drug = $income_drug->whereMonth('transactions.date', '=', Carbon::parse($request->date[0])->format('m'))
                    ->whereYear('transactions.date', '=', Carbon::parse($request->date[0])->format('Y'));
                $outcome_drug = $outcome_drug->whereMonth('transactions.date', '=', Carbon::parse($request->date[0])->format('m'))
                    ->whereYear('transactions.date', '=', Carbon::parse($request->date[0])->format('Y'));
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

            return view('livewire.report.print-laba-rugi', compact('outcome', 'date', 'income_action', 'income_drug', 'outcome_drug', 'isDownload'));
        } elseif ($request->type == 'Lap. Stock Ledger') {

            return view('livewire.report.print-stock-ledger', [
                'stockLedgers' => StockLedger::query()
                    ->with([
                        'item' => function ($query) {
                            $query->select('id', 'name');
                        },
                        'batch' => function ($query) {
                            $query->select('id', 'new_price', 'stock_entry_id', 'batch_number')
                                ->with([
                                    'stockEntry' => function ($query) {
                                        $query->select('id', 'branch')
                                            ->with([
                                                'branch' => function ($query) {
                                                    $query->select('id', 'name');
                                                }
                                            ]);
                                    }
                                ]);
                        },

                    ])
                    ->when($request->branch, function ($query) use ($request) {
                        $query->whereHas('batch', function ($query) use ($request) {
                            $query->whereHas('stockEntry', function ($query) use ($request) {
                                $query->where('branch_id', $request->branch);
                            });
                        });
                    })
                    ->when($request->batch, function ($query) use ($request) {
                        $query->where('batch_reference', $request->batch);
                    })
                    ->when($request->item_id, function ($query) use ($request) {
                        $query->where('item_id', $request->item_id);
                    })
                    ->when($request->date, function ($query) use ($request) {
                        $query->whereDate('created_at', '>=', $request->date[0])->whereDate('created_at', '<=', $request->date[1]);
                    })
                    ->oldest()
                    ->get(),
                'isDownload' => $request->isDownload
            ]);
        } elseif ($request->type == 'Lap. Stock Balance') {
            $stock = StockLedger::query()
                ->with([
                    'batch' => [
                        'stockEntry' => [
                            'branch'
                        ]
                    ],
                    'item'
                ])
                ->when($request->branch, function ($query) use ($request) {
                    $query->whereHas('batch', function ($query) use ($request) {
                        $query->whereHas('stockEntry', function ($query) use ($request) {
                            $query->where('branch_id', $request->branch);
                        });
                    });
                })
                ->when($request->item, function ($query) use ($request) {
                    $query->whereHas('batch', function ($query) use ($request) {
                        $query->where('item_id', $request->item);
                    });
                })
                ->get();

            $result = $stock->groupBy([function ($stockLedger) {
                return $stockLedger['batch']['stockEntry']['branch'];
            }, function ($stockLedger) {
                return $stockLedger['batch']['item_id'];
            }])->values();

            return view('livewire.report.print-stock-balance', [
                'type' => 'Lap. Stock Ledger',
                'result' => $result,
                'isDownload' => $request->isDownload
            ]);
        } elseif ($request->type == 'Lap. per Pasien') {
            $transaction = Transaction::query()
                ->with(['patient', 'doctor', 'drugMedDevs', 'laborates', 'actions', 'medicalRecord.registration', 'poli', 'branch'])
                ->when($request->branch != null, function ($query) use ($request) {
                    $query->where('branch_id', $request->branch);
                    // $query->whereHas('medicalRecord', function ($query) {
                    //     $query->whereHas('registration', function ($query) {
                    //     });
                    // });
                })
                // ->where('date', empty($request->date[0]) && empty($request->date[1]) ?  $request->date : date('Y-m-d'))
                ->when(isset($request->date[0]) && isset($request->date[1]), function ($query) use ($request) {
                    $query->whereBetween('date', $request->date);
                })
                ->when(!isset($request->date[0]) && !isset($request->date[1]), function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'));
                })
                ->when($request->doctor, function ($query) use ($request) {
                    $query->where('doctor', $request->doctor);
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('patient', function ($query) use ($request) {
                        $query->where('name', 'ilike', "%{$request->search}%");
                    });
                })
                ->get();

            return view('livewire.report.print-income-per-patient', [
                'transactions' => $transaction,
                'isDownload' => $request->isDownload
            ]);
        } elseif ($request->type == 'Lap. Obat dan Tindakan') {
            $transaction = Transaction::query()
                ->has('medicalRecord')
                ->with('drugMedDevs', 'paymentMethods', 'actions', 'laborates', 'poli')
                ->when($request->poli != null && $request->poli != '', function ($query) use ($request) {
                    $query->whereHas('poli', function ($q) use ($request) {
                        $q->where('name', $request->poli);
                    });
                })
                ->when($request->branch != null && $request->branch != '', function ($query) use ($request) {
                    $query->where('branch_id', $request->branch);
                })
                ->when(isset($request->date[0]) && isset($request->date[1]), function ($query) use ($request) {
                    $query->where('date', '>=', Carbon::parse($request->date[0])->format('Y-m-d'))
                        ->where('date', '<=', Carbon::parse($request->date[1])->format('Y-m-d'));
                }, function ($query) {
                    $query->where('date', Carbon::today()->format('Y-m-d'));
                })
                ->get();

            $transactionGrouped = $transaction->groupBy(['date', 'poli.name']);
            $transactionGroupedDrugMedDev = $transactionGrouped->map(function ($group) {
                return $group->map(fn ($item) => $item->pluck('drugMedDevs')->flatten()->groupBy('id')->values());
            });
            $transactionGroupedAction = $transactionGrouped->map(function ($group) {
                return $group->map(fn ($item) => $item->pluck('actions')->flatten()->groupBy('id')->values());
            });
            $transactionGroupedLaborate = $transactionGrouped->map(function ($group) {
                return $group->map(fn ($item) => $item->pluck('laborates')->flatten()->groupBy('id')->values());
            });

            $table = collect();
            foreach ($transactionGroupedDrugMedDev as $date => $drugMedDevsValue) {
                foreach ($drugMedDevsValue as $poli => $drugMedDevValue) {
                    foreach ($drugMedDevValue as $key => $value) {
                        $discountGroup = $value->groupBy('pivot.discount');
                        foreach ($discountGroup as $value) {
                            $total_qty = $value->reduce(fn ($c, $d) => $c + $d->pivot->qty);
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
                            $total_qty = $value->reduce(fn ($c, $d) => $c + $d->pivot->qty);
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
                            $total_qty = $value->reduce(fn ($c, $d) => $c + $d->pivot->qty);
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

            return view('livewire.report.print-obat-dan-tindakan', [
                'table' => $table->sortBy('date'),
                'total_price' => $table->sum('total'),
                'isDownload' => $request->isDownload
            ]);
        }
    }
}
