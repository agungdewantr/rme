<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TindakanExport implements FromCollection, WithHeadings
{
    protected $table;

    protected $totalPrice;

    public function __construct($table, $totalPrice)
    {
        $this->table = $table;
        $this->totalPrice = $totalPrice;
    }

    public function collection()
    {
        $data = [];

        $i = 1;

        foreach ($this->table as $item) {
            $data[] = [
                'No' => $i++,
                'Tanggal' => $item['date'],
                'Poli' => $item['poli'],
                'Tindakan' => $item['name'],
                'Jumlah' => $item['qty'],
                'Harga (Rp)' => $item['price'] ?? 0,
                'Total' => $item['total'] ?? 0,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Poli',
            'Tindakan',
            'Jumlah',
            'Harga (Rp)',
            'Total',
        ];
    }
}
