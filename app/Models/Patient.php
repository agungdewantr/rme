<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    use HasFactory, Uuid;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function insurances(): HasMany
    {
        return $this->hasMany(Insurance::class, 'patient_id');
    }

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class, 'patient_id', 'user_id');
    }

    public function registration(): HasMany
    {
        return $this->hasMany(Registration::class, 'user_id', 'user_id');
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class, 'patient_id');
    }

    public function obstetri(): HasMany
    {
        return $this->hasMany(Obstetri::class, 'patient_id', 'id');
    }
    public function familyIlnessHistories(): HasMany
    {
        return $this->hasMany(FamilyIllnessHistory::class, 'patient_id', 'id');
    }

    public function allergyHistories(): BelongsToMany
    {
        return $this->belongsToMany(AllergyHistory::class, 'patient_has_allergy_histories', 'patient_id', 'allergy_history_id')->withPivot(['id','indication']);
    }

    public function illnessHistories(): BelongsToMany
    {
        return $this->belongsToMany(IllnessHistory::class, 'patient_has_illness_histories', 'patient_id', 'illness_history_id')->withPivot(['therapy', 'id']);
    }

    public function firstEntry(): HasMany
    {
        return $this->hasMany(FirstEntry::class, 'patient_id');
    }
}
