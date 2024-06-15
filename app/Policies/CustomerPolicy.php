<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->type == 'A';
    }

    public function view(User $user, Customer $customer): bool
    {
        return $user->id == $customer->id;
    }


    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->id == $customer->id;
    }


    public function delete(User $user): bool
    {
        return $user->type == 'A';
    }

    public function updateBlock(User $user): bool
    {
        return $user->type == 'A';
    }
}
