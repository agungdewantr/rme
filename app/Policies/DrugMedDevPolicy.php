<?php

namespace App\Policies;

use App\Models\DrugMedDev;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DrugMedDevPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.drugmeddev-read')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DrugMedDev $drugMedDev): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.drugmeddev-read')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.drugmeddev-create')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DrugMedDev $drugMedDev): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.drugmeddev-update')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DrugMedDev $drugMedDev): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'master.drugmeddev-delete')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DrugMedDev $drugMedDev): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DrugMedDev $drugMedDev): bool
    {
        return false;
    }
}
