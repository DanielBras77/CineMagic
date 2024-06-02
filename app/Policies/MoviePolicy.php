<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MoviePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Movie $movie): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Movie $movie): bool
    {
        return true;
    }

    public function delete(User $user, Movie $movie): bool
    {
        return true;
    }

    public function restore(User $user, Movie $movie): bool
    {
        return true;
    }

    public function forceDelete(User $user, Movie $movie): bool
    {
        return true;
    }
}
