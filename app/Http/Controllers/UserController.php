<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\DB;
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
