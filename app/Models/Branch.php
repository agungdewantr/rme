<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory, Uuid;

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'branch_id');
    }

    public function stockEntry(): HasMany
    {
        return $this->hasMany(StockEntry::class, 'branch_id');
    }

    public function poli(): BelongsToMany
    {
        return $this->belongsToMany(Poli::class, 'branch_has_polis', 'branch_id', 'poli_id');
    }

    public function operationHour(): HasMany
    {
        return $this->hasMany(OperationalHour::class, 'branch_id');
    }
}
