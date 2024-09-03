<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transaction = Transaction::with(['paymentMethods', 'drugMedDevs', 'actions', 'laborates'])->get();

        foreach ($transaction as $key => $value) {
            foreach ($value->drugMedDevs as $dmd) {
                $value->drugMedDevs()->updateExistingPivot($dmd->id, ['price' => $dmd->selling_price]);
            }
            foreach ($value->actions as $a) {
                $value->actions()->updateExistingPivot($a->id, ['price' => $a->price]);
            }
            foreach ($value->laborates as $l) {
                $value->laborates()->updateExistingPivot($l->id, ['price' => (int)$l->price]);
            }
            foreach ($value->paymentMethods as $key => $p) {
                if ($p->name == 'Cash') {
                    $change = $p->pivot->amount - ($p->pivot->amount - ($value->paymentMethods->reduce(fn ($total, $item) => $total + $item->pivot->amount, 0) - ($value->drugMedDevs->reduce(fn ($a, $b) => $a + (($b->pivot->qty * $b->selling_price) - $b->pivot->discount), 0) + $value->actions->reduce(fn ($a, $b) => $a + (($b->pivot->qty * $b->price) - $b->pivot->discount), 0) + $value->laborates->reduce(fn ($a, $b) => $a + (($b->pivot->qty * (int) $b->price) - $b->pivot->discount), 0))));
                    $value->paymentMethods()->updateExistingPivot($p->id, ['change' => $change]);
                }
            }
        }
    }
}
