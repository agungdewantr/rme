<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Action extends Model
{
    use HasFactory, Uuid;

    public function medicalRecords(): BelongsToMany
    {
        return $this->belongsToMany(MedicalRecord::class, 'medical_record_has_actions', 'action_id', 'medical_record_id')->withPivot(['total']);
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'payment_actions', 'action_id', 'transaction_id')->withPivot(['discount']);
    }

    public function sipFee(): HasOne
    {
        return $this->hasOne(SipFee::class, 'action_id', 'id')->withDefault(['sip_fee' => 0, 'non_sip_fee' => 0]);
    }

    public function paymentAction(): HasMany
    {
        return $this->hasMany(PaymentAction::class, 'action_id', 'id');
    }
}
