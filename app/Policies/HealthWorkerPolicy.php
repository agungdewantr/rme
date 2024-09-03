<?php

namespace App\Policies;

use App\Models\HealthWorker;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HealthWorkerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.healthworker-read')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HealthWorker $healthWorker): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.healthworker-read')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.healthworker-create')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HealthWorker $healthWorker): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.healthworker-update')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HealthWorker $healthWorker): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.healthworker-delete')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HealthWorker $healthWorker): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HealthWorker $healthWorker): bool
    {
        return false;
    }
}
