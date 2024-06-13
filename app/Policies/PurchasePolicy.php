<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PurchasePolicy
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
        return $user->type == 'A' || $user->type == 'C';
    }

    public function view(User $user, Purchase $purchase): bool
    {
        return $user->type == 'A' || $user->id == $purchase->customer->id;
    }
}
