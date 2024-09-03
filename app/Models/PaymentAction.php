<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentAction extends Model
{
    use HasFactory;

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class, 'action_id');
    }
}
