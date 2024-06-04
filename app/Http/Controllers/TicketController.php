<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function show(Ticket $ticket): View
    {
        return view('tickets.show')->with('ticket', $ticket);
    }
}
