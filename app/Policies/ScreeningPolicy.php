<?php

namespace App\Policies;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScreeningPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type == 'E';
    }

    public function view(User $user, Screening $screening): bool
    {
        return $user->type == 'E';;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Screening $screening): bool
    {
        return false;
    }

    public function delete(User $user, Screening $screening): bool
    {
        return false;
    }
}
