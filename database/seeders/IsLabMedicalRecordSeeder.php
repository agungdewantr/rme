<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IsLabMedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicalRecord = MedicalRecord::all();

        foreach($medicalRecord as $mr){
            if($mr->date_lab != NULL){
                $mr->is_lab = true;
                $mr->save();
            }
        }
    }
}
