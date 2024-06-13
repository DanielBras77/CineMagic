<?php

namespace App\Policies;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConfigurationPolicy
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


    public function view(User $user, Configuration $configuration): bool
    {
        return false;
    }


    public function create(User $user): bool
    {
        return false;
    }


    public function update(User $user, Configuration $configuration): bool
    {
        return false;
    }

    public function delete(User $user, Configuration $configuration): bool
    {
        return false;
    }


    public function restore(User $user, Configuration $configuration): bool
    {
        return false;
    }


    public function forceDelete(User $user, Configuration $configuration): bool
    {
        return false;
    }
}
