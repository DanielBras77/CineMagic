<?php

namespace App\Policies;

use App\Models\Theater;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TheaterPolicy
{

    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->admin) {
            return true;
        }
        // When "Before" returns null, other methods (eg. viewAny, view, etc...) will be
        // used to check the user authorizaiton
        return null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Theater $theater): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Theater $theater): bool
    {
        return false;
    }

    public function delete(User $user, Theater $theater): bool
    {
        return false;
    }
}
