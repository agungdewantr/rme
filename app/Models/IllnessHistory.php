<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class IllnessHistory extends Model
{
    use HasFactory;

    public function medicalRecords(): BelongsToMany
    {
        return $this->belongsToMany(MedicalRecord::class, 'medical_record_has_illness_histories', 'illness_history_id', 'medical_record_id')->withPivot(['therapy']);
    }
}
