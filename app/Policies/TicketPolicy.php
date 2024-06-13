<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->type == 'A' || $user->type == 'E' || ($user->type == 'C' && $ticket->purchase->customer_id == $user->id);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return true;
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return true;
    }
}
