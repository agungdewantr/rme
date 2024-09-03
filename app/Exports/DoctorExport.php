<?php

namespace App\Exports;

use App\Models\Action;
use App\Models\DrugMedDev;
use App\Models\SipFee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class DoctorExport implements FromCollection, WithHeadings
{
    protected $doctor_id;
    protected $date;
    protected $sip;
    protected $table;

    public function __construct($table,$doctor_id = null, $date = null, $sip = null)
    {
        $this->table = $table;
        $this->doctor_id = $doctor_id;
        $this->date = $date;
        $this->sip = $sip;
    }

    public function collection()
    {

        $data = [];

        $i = 1;

        foreach ($this->table as $item) {
            $data[] = [
                'No' => $i++,
                'Tanggal' => $item['date'],
                'Dokter' => $item['doctor'],
                'Cabang' => $item['branch'],
                'Poli' => $item['poli'],
                'Nama' => $item['name'],
                'Jumlah' => $item['qty'],
                'Harga (Rp)' => (string) ($item['price'] ?? 0),
                'Total' => (string) ($item['total'] ?? 0)
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Dokter',
            'Cabang',
            'Poli',
            'Nama',
            'Jumlah',
            'Harga (Rp)',
            'Total'
        ];
    }
}
