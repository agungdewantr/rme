<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockBalanceExport implements FromCollection, WithHeadings
{
    public function __construct(protected $stockBalance)
    {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $result = collect();

        foreach ($this->stockBalance as $stockBalance) {
            foreach ($stockBalance as $key => $value) {
                $result->push([
                    'Barang' => $value[0]->item->name,
                    'Satuan' => $value[0]->item->uom,
                    'Stok Masuk' => $value->reduce(fn ($a, $b) => $a + ($b->in ?? 0), 0),
                    'Stok Keluar' => $value->reduce(fn ($a, $b) => $a + ($b->out ?? 0), 0),
                    'Stok Akhir' => $value->reduce(fn ($a, $b) => $a + ($b->in ?? 0) - ($b->out ?? 0), 0),
                    'Cabang' => $value[0]->batch->stockEntry->branch->name,
                    'Avg Value' => 'Rp' . number_format($value->avg('batch.new_price'), 0, '.', '.'),
                    'Balance Value' => 'Rp' . number_format($value->reduce(fn ($a, $b) => $a + ($b->in ?? 0) - ($b->out ?? 0), 0) * $value->avg('batch.new_price'), 0, '.', '.'),
                ]);
            }
        }
        return $result;
    }

    public function headings(): array
    {
        return [
            'Barang',
            'Satuan',
            'Stok Masuk',
            'Stok Keluar',
            'Stok Akhir',
            'Cabang',
            'Avg Value',
            'Balance Value',
        ];
    }
}
