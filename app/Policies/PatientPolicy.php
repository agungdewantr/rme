<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'patient-read')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Patient $patient): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'patient-read')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'patient-create')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Patient $patient): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'patient-update')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Patient $patient): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'patient-delete')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Patient $patient): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Patient $patient): bool
    {
        return false;
    }
}
