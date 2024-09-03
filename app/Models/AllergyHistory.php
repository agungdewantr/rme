<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AllergyHistory extends Model
{
    use HasFactory;

    public function medicalRecords(): BelongsToMany
    {
        return $this->belongsToMany(MedicalRecord::class, 'medical_record_has_allergy_histories', 'allergy_history_id', 'medical_record_id');
    }
}
