<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserLeave;
use App\Policies\UserLeavePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        UserLeave::class=>UserLeavePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
