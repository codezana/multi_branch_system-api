<?php

namespace App\Policies;

use App\Models\Branch;
use App\Models\User;

class BranchPolicy
{
    /**
     * Admins can view all branches; users only their own.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Admin can view any branch; user can only view their assigned branch.
     */
    public function view(User $user, Branch $branch): bool
    {
        return $user->role === 'admin' || $user->branch_id === $branch->id;
    }

    /**
     * Only admins can create branches.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Only admins can update branches.
     */
    public function update(User $user, Branch $branch): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Only admins can delete branches.
     */
    public function delete(User $user, Branch $branch): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Optional: restoring and force deleting (admin only).
     */
    public function restore(User $user, Branch $branch): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Branch $branch): bool
    {
        return $user->role === 'admin';
    }
}
