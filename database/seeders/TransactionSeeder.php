<?php

namespace Database\Seeders;

use App\Models\Poli;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transaction = Transaction::with('medicalRecord.registration.user')->get();

        $transaction->each(function ($transaction) {
            $poli = Poli::where('name', $transaction->medicalRecord?->registration?->poli)->first();
            $transaction->update([
                'poli_id' => $poli?->id ?? 1,
                'branch_id' => $transaction?->medicalRecord?->registration->branch_id ?? 1
            ]);
        });
    }
}
