<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthWorker extends Model
{
    use HasFactory, Uuid;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
