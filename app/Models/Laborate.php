<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Laborate extends Model
{
    use HasFactory;

    public function medicalRecords(): BelongsToMany
    {
        return $this->belongsToMany(MedicalRecord::class, 'medical_record_has_laborates', 'laborate_id', 'medical_record_id');
    }

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'payment_laborates', 'laborate_id', 'payment_id');
    }
}
