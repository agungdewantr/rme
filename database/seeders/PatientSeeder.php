<?php

namespace Database\Seeders;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patient = new Patient();
        $patient->patient_number = 'P.02.00001';
        $patient->name = 'Albert';
        $patient->address = 'Jalan Semolowaru';
        $patient->nik = '1234567890123456';
        $patient->pob = 'Belanda';
        $patient->dob = Carbon::parse('2022/01/01');
        $patient->phone_number = '087123456789';
        $patient->gender = true;
        $patient->city = 'Amsterdam';
        $patient->user_id = 2;
        $patient->job_id = 1;
        $patient->save();
    }
}
