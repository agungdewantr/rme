<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    use HasFactory, Uuid;

    public function branch(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'branch_has_polis', 'poli_id', 'branch_id');
    }

    public function checkups(): HasMany
    {
        return $this->hasMany(CheckUp::class, 'poli_id');
    }
}


