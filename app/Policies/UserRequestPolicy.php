<?php

namespace App\Policies;

use App\User;
use App\User_request;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any user_requests.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the user_request.
     *
     * @param  \App\User  $user
     * @param  \App\User_request  $userRequest
     * @return mixed
     */
    public function view(User $user, User_request $userRequest)
    {
        //
    }

    /**
     * Determine whether the user can create user_requests.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the user_request.
     *
     * @param  \App\User  $user
     * @param  \App\User_request  $userRequest
     * @return mixed
     */
    public function update(User $user, User_request $userRequest)
    {
        //
    }

    /**
     * Determine whether the user can delete the user_request.
     *
     * @param  \App\User  $user
     * @param  \App\User_request  $userRequest
     * @return mixed
     */
    public function delete(User $user, User_request $userRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the user_request.
     *
     * @param  \App\User  $user
     * @param  \App\User_request  $userRequest
     * @return mixed
     */
    public function restore(User $user, User_request $userRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the user_request.
     *
     * @param  \App\User  $user
     * @param  \App\User_request  $userRequest
     * @return mixed
     */
    public function forceDelete(User $user, User_request $userRequest)
    {
        //
    }
}
