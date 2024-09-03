<?php

namespace App\Exports;

use App\Models\DetailOutcome;
use App\Models\PaymentAction;
use App\Models\PaymentDrug;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LabaRugiExport implements FromCollection, WithHeadings
{
    protected $date;

    public function __construct($date = null)
    {
        $this->date = $date;
    }
    public function collection()
    {
        // Query untuk mengambil data yang ingin diekspor
        $outcome = DetailOutcome::select(\DB::raw('COALESCE(SUM(CAST(outcomes.nominal AS INTEGER)), 0) as total'), 'accounts.name')
        ->join('outcomes', 'outcomes.id', '=', 'detail_outcomes.outcomes_id')
        ->join('accounts', 'outcomes.account_id', '=', 'accounts.id');

        $income_action = PaymentAction::join('actions', 'actions.id', '=', 'payment_actions.action_id')
            ->join('transactions', 'transactions.id', '=', 'payment_actions.transaction_id')
            ->select(\DB::raw('COALESCE(SUM(CAST(payment_actions.qty AS INTEGER) * CAST(actions.price AS INTEGER)), 0) as grand_total'));

        $income_drug = PaymentDrug::join('drug_med_devs', 'drug_med_devs.id', '=', 'payment_drugs.drug_med_dev_id')
            ->join('transactions', 'payment_drugs.transaction_id', '=', 'transactions.id')
            ->select(\DB::raw('COALESCE(SUM(CAST(payment_drugs.qty AS INTEGER) * CAST(drug_med_devs.selling_price AS INTEGER)), 0) as grand_total'));

        $outcome_drug = PaymentDrug::join('drug_med_devs', 'drug_med_devs.id', '=', 'payment_drugs.drug_med_dev_id')
            ->join('transactions', 'payment_drugs.transaction_id', '=', 'transactions.id')
            ->select(\DB::raw('COALESCE(SUM(CAST(payment_drugs.qty AS INTEGER) * CAST(drug_med_devs.purchase_price AS INTEGER)), 0) as grand_total'));

        // Lakukan filter berdasarkan tanggal jika ada
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

        // Gabungkan semua data menjadi satu collection
        $data = collect([
            [
                'ID' => '',
                'Nama Akun' => 'Pendapatan',
                'Nominal' => $income_action ?? 0,
            ],
            [
                'ID' => '',
                'Nama Akun' => 'Penjualan Obat',
                'Nominal' => $income_drug ?? 0,
            ],
            [
                'ID' => '',
                'Nama Akun' => 'Total Pendapatan',
                'Nominal' => ($income_action + $income_drug ?? 0),
            ],
            [
                'ID' => '',
                'Nama Akun' => 'Pembelian Obat',
                'Nominal' => $outcome_drug ?? 0,
            ],
        ])->concat($outcome->map(function ($item) {
            return [
                'ID' => !isset(explode('-', $item->name)[1]) ? '-' : explode('-', $item->name)[0],
                'Nama Akun' =>!isset(explode('-', $item->name)[1]) ? $item->name  : explode('-', $item->name)[1],
                'Nominal' => $item->total ?? 0,
            ];
        }))->concat([
            [
                'ID' => '',
                'Nama Akun' => 'Laba / Rugi',
                'Nominal' => ($income_action + $income_drug) - ($outcome_drug + $outcome->sum('total') ?? 0),
            ]
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Akun',
            'Nominal',
        ];
    }
}
