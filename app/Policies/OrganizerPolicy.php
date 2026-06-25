<?php

namespace App\Policies;

use App\Models\Organizer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Organizer $organizer): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isOrganizer();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Organizer $organizer): bool
    {
        return (($user->isOrganizer()) && ($user->id === $organizer->created_by_user_id));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Organizer $organizer): bool
    {
        return (($user->isOrganizer()) && ($user->id === $organizer->created_by_user_id));
    }

    public function viewTrashed(User $user): bool
    {
        return $user->isOrganizer();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->isAdmin();
    }

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }
}
