<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrugMedDevPriceHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function drugMedDev(): BelongsTo
    {
        return $this->belongsTo(DrugMedDev::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
