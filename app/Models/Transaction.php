<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id'];

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function drugMedDevs(): BelongsToMany
    {
        return $this->belongsToMany(DrugMedDev::class, 'payment_drugs', 'transaction_id', 'drug_med_dev_id')
            ->withPivot(['discount', 'qty', 'id', 'batch_id', 'how_to_use', 'rule', 'price','isPromo']);
    }

    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(Action::class, 'payment_actions', 'transaction_id', 'action_id')->withPivot(['discount', 'qty', 'id', 'price','isPromo','doctor_fee']);
    }

    public function laborates(): BelongsToMany
    {
        return $this->belongsToMany(Laborate::class, 'payment_laborates', 'payment_id', 'laborate_id')->withPivot(['qty', 'id', 'discount', 'price']);
    }

    public function paymentMethods(): BelongsToMany
    {
        return $this->belongsToMany(PaymentMethod::class, 'transaction_payment_methods')->withPivot(['id', 'amount', 'bank', 'change']);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }
}
