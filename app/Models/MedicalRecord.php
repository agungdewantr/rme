<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MedicalRecord extends Model
{
    use HasFactory, Uuid;

    public function allergyHistories(): BelongsToMany
    {
        return $this->belongsToMany(AllergyHistory::class, 'medical_record_has_allergy_histories', 'medical_record_id', 'allergy_history_id');
    }

    public function illnessHistories(): BelongsToMany
    {
        return $this->belongsToMany(IllnessHistory::class, 'medical_record_has_illness_histories', 'medical_record_id', 'illness_history_id');
    }

    public function mainComplaints(): BelongsToMany
    {
        return $this->belongsToMany(MainComplaint::class, 'medical_record_has_main_complaints', 'medical_record_id', 'main_complaint_id');
    }

    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(Action::class, 'medical_record_has_actions', 'medical_record_id', 'action_id')->withPivot(['total', 'id']);
    }

    public function drugMedDevs(): BelongsToMany
    {
        return $this->belongsToMany(DrugMedDev::class, 'medical_record_has_drug_med_devs', 'medical_record_id', 'drug_med_dev_id')->withPivot(['total', 'rule', 'how_to_use', 'id']);
    }

    public function healthWorker(): BelongsTo
    {
        return $this->belongsTo(HealthWorker::class, 'health_worker_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usgs(): HasMany
    {
        return $this->hasMany(Usg::class, 'medical_record_id');
    }

    public function laborate(): BelongsToMany
    {
        return $this->belongsToMany(Laborate::class, 'medical_record_has_laborates', 'medical_record_id', 'laborate_id');
    }

    public function checks(): HasMany
    {
        return $this->hasMany(Check::class, 'medical_record_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'medical_record_id');
    }

    public function firstEntry(): BelongsTo
    {
        return $this->belongsTo(FirstEntry::class, 'first_entry_id');
    }
}
