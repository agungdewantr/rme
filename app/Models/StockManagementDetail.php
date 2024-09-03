<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockManagementDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function stockEntry(): BelongsTo
    {
        return $this->belongsTo(StockEntry::class);
    }
}
