<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserLeave;
use Illuminate\Auth\Access\Response;

class UserLeavePolicy
{
    /**
     * Determine whether the user can view any models.
     */

    public function edit(User $user,User $authUser)
    {
        return $authUser->userLeave->status===2;
    }


}
