<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncomePerPatientExport implements FromCollection, WithHeadings
{
    public function __construct(protected $transactions)
    {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $result = collect();

        foreach ($this->transactions as $transaction) {
            $drugMedDevsCount = $transaction->drugMedDevs->count();
            $actionsCount = $transaction->actions->count();
            $laboratesCount = $transaction->laborates->count();
            if ($drugMedDevsCount > $actionsCount && $drugMedDevsCount > $laboratesCount) {
                for ($i = 0; $i < $transaction->drugMedDevs->count(); $i++) {
                    $result->push([
                        "Tanggal" => Carbon::parse($transaction->date)->format('d-m-Y'),
                        "Pasien" => ucwords(strtolower($transaction->patient->name)),
                        "Dokter" => $transaction->doctor?->name,
                        "Poli" => $transaction->medicalRecord?->registration->poli,
                        "Tindakan" => $transaction->actions->count() >= $i + 1 ? $transaction->actions[$i]->name : '-',
                        "Disc Tindakan (Rp)" => $transaction->actions->count() >= $i + 1 ? $transaction->actions[$i]->pivot->discount : 'Rp0',
                        "Laborate" => $transaction->laborates->count() >= $i + 1 ? $transaction->laborates[$i]->name : '-',
                        "Disc Laborate (Rp)" => $transaction->laborates->count() >= $i + 1 ? $transaction->laborates[$i]->pivot->discount : 'Rp0',

                        "Obat" => $transaction->drugMedDevs[$i]->name,
                        "Disc Obat (Rp)" => $transaction->drugMedDevs[$i]->pivot->discount,
                        "Total" => ($transaction->actions->count() >= $i + 1 ? $transaction->actions[$i]->price * $transaction->actions[$i]->pivot->qty - $transaction->actions[$i]->pivot->discount : 0) +
                        ($transaction->laborates->count() >= $i + 1 ? $transaction->laborates[$i]->price * $transaction->laborates[$i]->pivot->qty - $transaction->laborates[$i]->pivot->discount : 0)
                        + ($transaction->drugMedDevs[$i]->selling_price * $transaction->drugMedDevs[$i]->pivot->qty - $transaction->drugMedDevs[$i]->pivot->discount),
                    ]);
                }
            } elseif ($actionsCount > $drugMedDevsCount && $actionsCount > $laboratesCount) {
                for ($i = 0; $i < $transaction->actions->count(); $i++) {
                    $result->push([
                        "Tanggal" => Carbon::parse($transaction->date)->format('d-m-Y'),
                        "Pasien" => ucwords(strtolower($transaction->patient->name)),
                        "Dokter" => $transaction->doctor?->name,
                        "Poli" => $transaction->medicalRecord?->registration->poli,
                        "Tindakan" => $transaction->actions[$i]->name,
                        "Disc Tindakan (Rp)" => $transaction->actions[$i]->pivot->discount,
                        "Laborate" => $transaction->laborates->count() >= $i + 1 ? $transaction->laborates[$i]->name : '-',
                        "Disc Laborate (Rp)" => $transaction->laborates->count() >= $i + 1 ? $transaction->laborates[$i]->pivot->discount : 'Rp0',

                        "Obat" => $transaction->drugMedDevs->count() >= $i + 1 ? $transaction->drugMedDevs[$i]->name : '-',
                        "Disc Obat (Rp)" => $transaction->drugMedDevs->count() >= $i + 1 ? $transaction->drugMedDevs[$i]->pivot->discount : 'Rp0',
                        "Total" => ($transaction->drugMedDevs->count() >= $i + 1 ? $transaction->drugMedDevs[$i]->selling_price * $transaction->drugMedDevs[$i]->pivot->qty - $transaction->drugMedDevs[$i]->pivot->discount : 0) +
                        ($transaction->laborates->count() >= $i + 1 ? $transaction->laborates[$i]->price * $transaction->laborates[$i]->pivot->qty - $transaction->laborates[$i]->pivot->discount : 0)
                        + ($transaction->actions[$i]->price * $transaction->actions[$i]->pivot->qty - $transaction->actions[$i]->pivot->discount),
                    ]);
                }
            } elseif ($laboratesCount > $drugMedDevsCount && $laboratesCount > $actionsCount) {
                for ($i = 0; $i < $transaction->laborates->count(); $i++) {
                    $result->push([
                        "Tanggal" => Carbon::parse($transaction->date)->format('d-m-Y'),
                        "Pasien" => ucwords(strtolower($transaction->patient->name)),
                        "Dokter" => $transaction->doctor?->name,
                        "Poli" => $transaction->medicalRecord?->registration->poli,
                        "Tindakan" => $transaction->actions->count() >= $i + 1 ? $transaction->actions[$i]->name : '-',
                        "Disc Tindakan (Rp)" => $transaction->actions->count() >= $i + 1 ? $transaction->actions[$i]->pivot->discount : 'Rp0',
                        "Laborate" => $transaction->laborates[$i]->name,
                        "Disc Laborate (Rp)" => $transaction->labprates[$i]->pivot->discount,
                        "Obat" => $transaction->drugMedDevs->count() >= $i + 1 ? $transaction->drugMedDevs[$i]->name : '-',
                        "Disc Obat (Rp)" => $transaction->drugMedDevs->count() >= $i + 1 ? $transaction->drugMedDevs[$i]->pivot->discount : 'Rp0',
                        "Total" =>
                        ($transaction->laborates[$i]->price * $transaction->laborates[$i]->pivot->qty - $transaction->laborates[$i]->pivot->discount) +
                        ($transaction->actions->count() >= $i + 1 ? $transaction->actions[$i]->price * $transaction->actions[$i]->pivot->qty - $transaction->actions[$i]->pivot->discount : 0) +
                        ($transaction->drugMedDevs->count() >= $i + 1 ? $transaction->drugMedDevs[$i]->selling_price * $transaction->drugMedDevs[$i]->pivot->qty - $transaction->drugMedDevs[$i]->pivot->discount : 0)

                    ]);
                }
            }

        }

        return $result;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Pasien',
            'Dokter',
            'Poli',
            'Tindakan',
            'Disc Tindakan (Rp)',
            'Laborate',
            'Disc Laborate (Rp)',
            'Obat',
            'Disc Obat (Rp)',
            'Total',
        ];
    }
}
