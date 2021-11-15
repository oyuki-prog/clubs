<?php

namespace App\Policies;

use App\Models\ClubRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClubRolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ClubRole $clubRole)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ClubRole $clubRole)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ClubRole $clubRole)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ClubRole $clubRole)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClubRole  $clubRole
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ClubRole $clubRole)
    {
        //
    }
}
