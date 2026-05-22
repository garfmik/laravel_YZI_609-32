<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-review', function (User $user) {
            return true;
        });

        Gate::define('update-restaurant', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('create-restaurant', function (User $user) {
            return true;
        });

        Gate::define('delete-restaurant', function (User $user) {
            dd($user);
        });

    }
}
