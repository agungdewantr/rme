<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class PendapatanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        $data = [];

        $i = 1;
        $grand_total = 0;
        $sum_action = 0;
        $sum_laborate = 0;
        $sum_drug = 0;
        $sum_cash = 0;
        $sum_edc = 0;
        $sum_transfer = 0;
        $sum_harian = 0;
        $sum_qris = 0;

        foreach($this->results as $item){
            $data[] = [
                'No' => (string) ($i++),
                'Tanggal' => (string) ($item->date),
                'Cabang' => (string) ($item->branch),
                'Tindakan' => (string) ($item->total_action ?? 0),
                'Laborate' => (string) ($item->total_laborate ?? 0),
                'Obat' => (string) ($item->total_drug ?? 0),
                // 'Obat Langsung' => (string) ($item->total_ds,
                'Pembayaran Tunai' => (string) ($item->total_cash ?? 0),
                'Pembayaran EDC' => (string) ($item->total_edc ?? 0),
                'Pembayaran Transfer' => (string) ($item->total_transfer ?? 0),
                'Pembayaran QRIS' => (string) ($item->total_qris ?? 0),
                // 'Uang Tunai Akumulatif' => (string) ($item->accumulativeCash ?? 0),
                'Pendapatan Harian' => (string) ($item->total_cash+$item->total_edc+$item->total_transfer+ $item->total_qris ?? 0)
            ];


            $grand_total += $item->total_cash + $item->total_edc + $item->total_transfer + $item->total_qris ?? 0;
            $sum_action += $item->total_action ?? 0;
            $sum_laborate += $item->total_laborate ?? 0;
            $sum_drug += $item->total_drug ?? 0;
            $sum_cash += $item->total_cash ?? 0;
            $sum_edc += $item->total_edc ?? 0;
            $sum_harian += $item->total_cash - $item->total_outcome_cash ?? 0;
            $sum_transfer += $item->total_transfer ?? 0;
            $sum_qris += $item->total_qris ?? 0;

        }

        $data[] = [
            'No' => '',
            'Tanggal' => '',
            'Cabang' => 'Grand Total',
            'Tindakan' => (string) ($sum_action),
            'Laborate' => (string) ($sum_laborate),
            'Obat' => (string) ($sum_drug),
            // 'Obat Langsung' => (string) ('',
            'Pembayaran Tunai' => (string) ($sum_cash),
            'Pembayaran EDC' => (string) ($sum_edc),
            'Pembayaran Transfer' => (string) ($sum_transfer),
            'Pembayaran QRIS' => (string) ($sum_qris),
            // 'Uang Tunai Akumulatif' => (string) $this->results[0]->accumulativeCash ?? 0,
            'Pendapatan Harian' => (string) ($grand_total)
        ];

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Cabang',
            'Tindakan',
            'Laborate',
            'Obat',
            // 'Obat Langsung',
            'Pembayaran Tunai',
            'Pembayaran EDC',
            'Pembayaran Transfer',
            'Pembayaran QRIS',
            // 'Uang Tunai Akumulatif',
            'Pendapatan Harian'
        ];
    }
}
