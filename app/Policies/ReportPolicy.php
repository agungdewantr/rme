<?php

namespace App\Policies;

use App\Models\User;

class ReportPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user): bool
    {
        $user->load('role.permissions');
        return $user->role != null && ($user->role->permissions->where('name', 'report-read')->first() != null || $user->role->name == 'superAdmin');
    }
}
