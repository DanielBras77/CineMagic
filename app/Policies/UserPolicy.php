<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->type=='A';
    }

    public function create(User $user): bool
    {
        return $user->type=='A';
    }

    public function view(User $user, User $model): bool
    {
        return $user->type=='A' || $user->id == $model->id;
    }

    public function update(User $user, User $model): bool
    {
        return $user->type=='A' || $user->id == $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->type=='A' && $user->id != $model->id;
    }

    public function updateBlock(User $user): bool
    {
        return $user->type == 'A';
    }
}
