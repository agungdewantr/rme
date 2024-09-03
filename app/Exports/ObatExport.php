<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObatExport implements FromCollection, WithHeadings
{
    protected $reports;
    protected $reportTypeDrug;
    protected $is_kumulatif;
    protected $date;

    public function __construct($reports, $reportTypeDrug, $is_kumulatif, $date)
    {
        $this->reports = $reports;
        $this->reportTypeDrug = $reportTypeDrug;
        $this->is_kumulatif = $is_kumulatif;
        $this->date = $date;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->reports as $item) {
            $data[] = [
                'Tanggal' => $item['tanggal'],
                'Poli' =>  $item['poli'] ?? '-',
                'Obat' => $item['obat'] . ' ' . ($item['is_discount'] == 1 ? '(Disc)' : ''),
                'Jenis Pembelian' => $item['is_langsung'] == 1 ? 'Obat Langsung' : 'Obat Resep',
                'Jumlah' =>  $item['jumlah'],
                'Harga' => $item['harga'],
                'Total' => $item['total'],

            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Poli',
            'Obat',
            'Jenis Pembelian',
            'Jumlah',
            'Harga',
            'Total',
        ];
    }
}
