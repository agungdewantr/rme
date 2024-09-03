<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockLedgerExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected $stockLedgers
    ) {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $result = collect();

        foreach ($this->stockLedgers as $stockLedger) {
            $result->push([
                'Tanggal' => $stockLedger->created_at->format('d-m-Y'),
                'Cabang' => $stockLedger->batch->stockEntry->branch->name,
                'Barang' => $stockLedger->item->name,
                'Stok Awal' => $stockLedger->current_qty,
                'Stok Masuk' => $stockLedger->in,
                'Stok Keluar' => $stockLedger->out > 0 ? '-' . $stockLedger->out : $stockLedger->out,
                'Stok Akhir' => $stockLedger->qty,
                'Batch' => $stockLedger->batch_reference,
                'Value' => 'Rp' . number_format($stockLedger->batch->new_price, 0, '.', '.'),
                'Balance Value' => 'Rp' . number_format($stockLedger->batch->new_price * $stockLedger->qty, 0, '.', '.'),
            ]);
        }
        return $result;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Cabang',
            'Barang',
            'Stok Awal',
            'Stok Masuk',
            'Stok Keluar',
            'Stok Akhir',
            'Batch',
            'Value',
            'Balance Value',
        ];
    }
}
