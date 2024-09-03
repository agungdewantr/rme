<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_method = ['Cash', 'EDC','Transfer','QRIS'];
        foreach ($payment_method as $pm) {
            $payment_method = new PaymentMethod();
            $payment_method->name = $pm;
            $payment_method->is_bank = $pm != 'Cash';
            $payment_method->save();
        }
    }
}
