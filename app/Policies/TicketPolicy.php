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

    // Não sei se é validate??
    public function validate(User $user): bool
    {
        return $user->type == 'E';
    }
}
