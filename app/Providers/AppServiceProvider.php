<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        /*
        Gate::define('admin', function (User $user) {
            Only "administrator" users can "admin"
            return $user->admin;
        });
        */
    }
}
