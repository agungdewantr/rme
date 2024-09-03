<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::where('date','>','2024-06-19')->get();
        foreach($transactions as $t)
        {
            $t->paymentMethods()->attach($t,['amount' => (int)$t->payment_amount ?? 0, 'payment_method_id' => PaymentMethod::where('name', 'ilike', '%' . $t->payment_method . '%')->first()->id]);
        }
    }
}
