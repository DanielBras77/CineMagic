<?php

namespace App\Policies;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScreeningPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Screening $screening): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Screening $screening): bool
    {
        return true;
    }

    public function delete(User $user, Screening $screening): bool
    {
        return true;
    }

    public function restore(User $user, Screening $screening): bool
    {
        return true;
    }

    public function forceDelete(User $user, Screening $screening): bool
    {
        return true;
    }
}
