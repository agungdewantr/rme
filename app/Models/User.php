<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'user_id');
    }

    public function insurances(): HasMany
    {
        return $this->hasMany(Insurance::class, 'user_id');
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'user_id');
    }

    public function vaccines(): HasMany
    {
        return $this->hasMany(Vaccine::class, 'user_id');
    }

    public function healthWorker(): HasOne
    {
        return $this->hasOne(HealthWorker::class, 'user_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function medicalRecordsDoctor(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'doctor_id');
    }

    public function medicalRecordsNurse(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'nurse_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_filter');
    }
}
