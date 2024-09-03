<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockEntry extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'supplier_id',
        'date',
        'stock_entry_number',
        'purpose',
        'status',
        'receiver_id',
        'branch_id',
        'description',
        'grand_total'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(DrugMedDev::class, 'batches', 'stock_entry_id', 'item_id')
            ->withPivot(['qty', 'expired_date', 'batch_number', 'new_price', 'id', 'qty_ori'])->withTimestamps();
    }

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'stock_entry_has_batches', 'stock_entry_id', 'batch_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(StockManagementDetail::class);
    }
}
