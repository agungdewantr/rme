<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentDrug extends Model
{
    use HasFactory;

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function drugMedDev(): BelongsTo
    {
        return $this->belongsTo(DrugMedDev::class, 'drug_med_dev_id');
    }
}
