<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'action_id',
        'sip_fee',
        'non_sip_fee',
    ];

    public function action()
    {
        return $this->belongsTo(Action::class);
    }
}
