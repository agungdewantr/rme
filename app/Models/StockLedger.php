<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_reference',
        'current_qty',
        'in',
        'out',
        'qty',
        'qty',
        'item_id',
        'batch_reference'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(DrugMedDev::class, 'item_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_reference', 'batch_number');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'document_reference', 'invoice_number');
    }

    public function stockEntry(): BelongsTo
    {
        return $this->belongsTo(StockEntry::class, 'document_reference', 'stock_entry_number');
    }
}
