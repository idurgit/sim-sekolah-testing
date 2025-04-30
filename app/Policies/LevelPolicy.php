<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Level;
use Illuminate\Auth\Access\HandlesAuthorization;

class LevelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_level');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Level $level): bool
    {
        return $user->can('view_level');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_level');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Level $level): bool
    {
        return $user->can('update_level');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Level $level): bool
    {
        return $user->can('delete_level');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_level');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Level $level): bool
    {
        return $user->can('force_delete_level');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_level');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Level $level): bool
    {
        return $user->can('restore_level');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_level');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Level $level): bool
    {
        return $user->can('replicate_level');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_level');
    }
}
