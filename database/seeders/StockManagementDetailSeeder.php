<?php

namespace Database\Seeders;

use App\Models\StockEntry;
use App\Models\StockManagementDetail;
use Illuminate\Database\Seeder;

class StockManagementDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stockEntries = StockEntry::query()
            ->with(['items', 'batches' => ['item']])
            ->get();

        foreach ($stockEntries as $item) {
            foreach ($item->batches as $batch) {
                StockManagementDetail::query()->create([
                    'stock_entry_id' => $item->id,
                    'item_name' => $batch->item->name,
                    'item_uom' => $batch->item->uom,
                    'item_qty' => $batch->qty_ori,
                    'item_price' => $batch->new_price,
                    'item_expired_date' => $batch->expired_date,
                ]);
            }
            foreach ($item->items as $obat) {
                StockManagementDetail::query()->create([
                    'stock_entry_id' => $item->id,
                    'item_name' => $obat->name,
                    'item_uom' => $obat->uom,
                    'item_qty' => $obat->pivot->qty_ori,
                    'item_price' => $obat->pivot->new_price,
                    'item_expired_date' => $obat->pivot->expired_date,
                ]);
            }
        }
    }
}
