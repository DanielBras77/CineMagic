<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }


    public function view(User $user, Customer $customer): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        return true;
    }


    public function update(User $user, Customer $customer): bool
    {
        return true;
    }


    public function delete(User $user, Customer $customer): bool
    {
        return true;
    }


    public function restore(User $user, Customer $customer): bool
    {
        return true;
    }


    public function forceDelete(User $user, Customer $customer): bool
    {
        return true;
    }
}
