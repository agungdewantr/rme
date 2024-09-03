<?php

namespace Database\Seeders;

use App\Models\StockEntry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stockEntries = StockEntry::with('items', 'batches')->get();
        // dd($stockEntries->toArray());
        foreach ($stockEntries as $value) {
            if ($value->items) {
                $value->update([
                    'grand_total' => array_reduce(
                        $value->items->toArray(),
                        fn ($total, $item) => $total + $item['pivot']['qty'] * $item['pivot']['new_price'],
                        0
                    )
                ]);
            } else {
                $value->update([
                    'grand_total' => array_reduce($value->batches->toArray(), fn ($total, $batch) => $total + $batch['qty'] * $batch['new_price'], 0)
                ]);
            }
        }
    }
}
