<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'transaction_payment_methods','payment_method_id','transaction_id')->withPivot(['amount']);
    }
}
