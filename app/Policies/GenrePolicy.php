<?php

namespace App\Policies;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GenrePolicy
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
        return $user->type == 'A';
    }


    public function view(User $user, Genre $genre): bool
    {
        return $user->type == 'A';
    }


    public function create(User $user): bool
    {
        return $user->type == 'A';
    }


    public function update(User $user, Genre $genre): bool
    {
        return $user->type == 'A';
    }


    public function delete(User $user, Genre $genre): bool
    {
        return $user->type == 'A';
    }
}
