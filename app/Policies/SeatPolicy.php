<?php

namespace App\Policies;

use App\Models\Seat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SeatPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Seat $seat): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        return true;
    }


    public function update(User $user, Seat $seat): bool
    {
        return true;
    }


    public function delete(User $user, Seat $seat): bool
    {
        return true;
    }


    public function restore(User $user, Seat $seat): bool
    {
        return true;
    }


    public function forceDelete(User $user, Seat $seat): bool
    {
        return true;
    }
}
