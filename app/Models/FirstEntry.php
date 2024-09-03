<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FirstEntry extends Model
{
    use HasFactory, Uuid;

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
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


}
