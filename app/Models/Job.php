<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory, Uuid;

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'job_id');
    }
}
