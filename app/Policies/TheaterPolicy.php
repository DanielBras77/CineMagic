<?php

namespace App\Policies;

use App\Models\Theater;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TheaterPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Theater $theater): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Theater $theater): bool
    {
        return true;
    }

    public function delete(User $user, Theater $theater): bool
    {
        return true;
    }

    public function restore(User $user, Theater $theater): bool
    {
        return true;
    }

    public function forceDelete(User $user, Theater $theater): bool
    {
        return true;
    }
}
