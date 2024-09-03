<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailOutcome extends Model
{
    use HasFactory, Uuid;

    public function outcome(): BelongsTo
    {
        return $this->belongsTo(Outcome::class, 'outcomes_id');
    }

    public function stockEntry(): BelongsTo
    {
        return $this->belongsTo(StockEntry::class, 'stock_entry_id');
    }
}
