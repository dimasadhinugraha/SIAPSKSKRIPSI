<?php

namespace App\Policies;

use App\Models\LetterRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LetterRequestPolicy
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
        return true; // Anyone can view the index page of their own requests
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LetterRequest  $letterRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LetterRequest $letterRequest)
    {
        // User can view their own letter request.
        // Admin can view any letter request.
        // The relevant RT/RW can also view the request.
        return $user->id === $letterRequest->user_id 
            || $user->isAdmin() 
            || $user->id === $letterRequest->user->rt_id
            || $user->id === $letterRequest->user->rw_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Any authenticated user can create a letter request.
        return $user->is_verified;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LetterRequest  $letterRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LetterRequest $letterRequest)
    {
        // Generally, users should not be able to update requests once submitted.
        // Only admins might be able to.
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LetterRequest  $letterRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LetterRequest $letterRequest)
    {
        // Only admins can delete letter requests.
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LetterRequest  $letterRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LetterRequest $letterRequest)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LetterRequest  $letterRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LetterRequest $letterRequest)
    {
        return $user->isAdmin();
    }
}
