<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

class ScreeningController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Screening::class);
    }

    public function index(): View
    {
        return view('screenings.index')
        ->with('screenings', Screening::orderBy('name')->paginate(20)->withQueryString());
    }


    public function create(): View
    {
        $newScreening = new Screening();
        return view('screenings.create')->with('screening', $newScreening);
    }


    public function store(Request $request): RedirectResponse
    {
        $newScreening = Screening::create($request->validated());
        $url = route('seats.show', ['seat' => $newScreening]);
        $htmlMessage = "Screening <a href='$url'><u>{$newScreening->row}</u></a> ({$newScreening->id}) has been created successfully!";
        return redirect()->route('seats.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    public function show(Screening $screening): View
    {
        return view('screenings.show')->with('screening', $screening);
    }


    public function showScreening(Screening $screening)
    {
        return view('screenings.showcase')->with('screening', $screening);
    }


    public function edit(Screening $screening): View
    {
        return view('screenings.edit')->with('screening', $screening);
    }


    public function update(Request $request, Screening $screening): RedirectResponse
    {
        $screening->update($request->validated());
        $url = route('screenings.show', ['screening' => $screening]);
        $htmlMessage = "Screening <a href='$url'><u>{$screening->name}</u></a> ({$screening->code}) has been updated successfully!";
        return redirect()->route('screenings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    public function destroy(Screening $screening): RedirectResponse
    {

        $screening->delete();
        $alertType = 'success';
        $alertMsg = "Screening {$screening->row}{$screening->id} has been deleted successfully!";

        return redirect()->route('screenings.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
