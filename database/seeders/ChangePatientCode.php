<?php

namespace Database\Seeders;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChangePatientCode extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();

        foreach ($patients as $p) {
            $p->patient_number = explode('.', $p->patient_number)[2] . '.' . Carbon::parse($p->dob)->format('dmy');
            $p->save();
        }
    }
}
