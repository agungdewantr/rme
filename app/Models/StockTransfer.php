<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StockTransfer extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id'];

    public function fromBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'form_branch_id');
    }

    public function toBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'stock_transfer_batches', 'stock_transfer_id', 'batch_id')
        ->withPivot(['qty_used']);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(DrugMedDev::class, 'stock_transfer_items', 'stock_transfer_id', 'item_id')
        ->withPivot(['qty_total']);
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(HealthWorker::class, 'receiver_id');
    }
}
