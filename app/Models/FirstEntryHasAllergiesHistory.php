<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FirstEntryHasAllergiesHistory extends Model
{
    use HasFactory;

    public function allergy(): BelongsTo
    {
        return $this->belongsTo(AllergyHistory::class, 'allergy_history_id');
    }
}
