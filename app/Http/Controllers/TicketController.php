<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Screening;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
            # msg que n existe ticket
        }
    }

    public function updateStatus(Request $request, Ticket $ticket){
        $ticket->status = $request->status;
        $ticket->save();
        #msg de sucesso
    }
}
