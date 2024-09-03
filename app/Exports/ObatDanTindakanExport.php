<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ObatDanTindakanExport implements FromCollection
{
    protected $totalPrice;
    protected $obatDanTindakan;
    public function __construct($obatDanTindakan, $totalPrice)
    {
        $this->obatDanTindakan = $obatDanTindakan;
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = [];

        $i = 1;

        foreach ($this->obatDanTindakan as $item) {
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
            'Obat/Tindakan',
            'Jumlah',
            'Harga (Rp)',
            'Total',
        ];
    }
}
