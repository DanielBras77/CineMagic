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
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }


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


    public function destroyPhoto(Theater $theater): RedirectResponse
    {
        /* Onde a foto pode ser nula é necessário colocar este método, ver se é preciso
        if ($theater->user->photo_url) {
            if (Storage::fileExists('public/theaters/' . $theater->photo_filename)) {
                Storage::delete('public/theaters/' . $theater->photo_filename);
            }
            $theater->photo_filename = null;
            $theater->save();
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Photo of theater $theater {$theater->name} has been deleted.");
        }*/
        return redirect()->back();
    }
}
