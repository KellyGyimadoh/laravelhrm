<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authUser)
    {
        return $authUser->status===2;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser)
    {
        return $authUser->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser)
    {
        return $authUser->role === 'admin';
    }
    public function viewstaff(User $authUser)
    {
        return $authUser->role==='staff';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function delete(User $authUser)
    {
        return $authUser->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */

    /**
     * Determine whether the user can restore the model.
     */


}
