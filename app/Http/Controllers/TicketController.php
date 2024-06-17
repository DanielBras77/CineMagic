<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Screening;

class TicketController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Ticket::class);
    }


    public function show(Ticket $ticket): View
    {
        return view('tickets.show')->with('ticket', $ticket);
    }

    public function validate(Request $request, Screening $screening){
        $url = $request->url??'';
        $ticket = Ticket::where('qrcode_url', $url);

        if ($ticket->screening->id == $screening->id) {
            return view('tickets.show', compact('ticket'));
        }
        else {
            $alertType = 'danger';
            $alertMsg = "It was not possible to validate the ticket! The ticket does not exist!";

            return redirect()->route('tickets.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
        }
    }

    public function updateStatus(Request $request, Ticket $ticket){
        $ticket->status = $request->status;
        $ticket->save();

        $alertType = 'success';
        $alertMsg = "It was not possible to validate the ticket! The ticket does not exist!";

            return redirect()->route('users.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
