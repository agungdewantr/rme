<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionEstimatedArrivalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::with('medicalRecord.registration')->get();
        $transactions->each(function ($transaction) {
            $transaction->update([
                'estimated_arrival' => $transaction->medicalRecord?->registration?->estimated_arrival ?? (explode(' ', $transaction->created_at)[1] <= '12:00:00' ? 'Poli Pagi' : 'Poli Sore'),
            ]);
        });
    }
}
