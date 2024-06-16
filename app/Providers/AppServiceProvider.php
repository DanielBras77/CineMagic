<?php

namespace App\Providers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {

        Gate::define('admin', function (User $user) {
            // Only "administrator" users can "admin"
            return $user->type == 'A';
        });


        Gate::define('no-blocked', function (?User $user) {

            return !$user->blocked;
        });


        Gate::define('use-cart', function (?User $user) {

            return $user==null || $user->type == 'C';
        });

    }
}
