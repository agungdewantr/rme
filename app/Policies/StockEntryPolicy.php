<?php

namespace App\Policies;

use App\Models\StockEntry;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StockEntryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'stock_entry-read')->first() != null || $user->role->name == 'superAdmin');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StockEntry $stockEntry): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'stock_entry-read')->first() != null || $user->role->name == 'superAdmin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'stock_entry-create')->first() != null || $user->role->name == 'superAdmin');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StockEntry $stockEntry): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'stock_entry-update')->first() != null || $user->role->name == 'superAdmin');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StockEntry $stockEntry): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'stock_entry-delete')->first() != null || $user->role->name == 'superAdmin');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StockEntry $stockEntry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StockEntry $stockEntry): bool
    {
        return false;
    }
}
