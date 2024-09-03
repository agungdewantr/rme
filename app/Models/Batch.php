<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Batch extends Pivot
{
    protected $table = "batches";

    protected $guarded = [
        'id'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(DrugMedDev::class, 'item_id');
    }

    public function stockEntry(): BelongsTo
    {
        return $this->belongsTo(StockEntry::class, 'stock_entry_id');
    }

    public function stockTransfers(): BelongsToMany
    {
        return $this->belongsToMany(StockTransfer::class, 'stock_transfer_batches', 'batch_id', 'stock_transfer_id');
    }
}
