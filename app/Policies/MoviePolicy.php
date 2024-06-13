<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MoviePolicy
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

    public function view(User $user, Movie $movie): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Movie $movie): bool
    {
        return false;
    }

    public function delete(User $user, Movie $movie): bool
    {
        return false;
    }
}
