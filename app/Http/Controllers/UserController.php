<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserFormRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
      /*  use AuthorizesRequests;
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }*/


    public function index()
    {

    }


    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show(Ticket $ticket)
    {

    }


    public function edit(Ticket $ticket)
    {

    }

    public function update(Request $request, Ticket $ticket)
    {

    }


    public function destroy(Ticket $ticket)
    {

    }
}
