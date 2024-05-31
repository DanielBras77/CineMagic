<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Theater;
use Illuminate\View\View;
use App\Http\Requests\SeatFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SeatController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Seat::class);
    }

    public function index(Request $request): View
    {
        $theaters = Theater::orderBy('name')->pluck('name', 'id')->toArray();
        $theaters = array_merge([null => 'Any theater'], $theaters);
        $filterByTheater = $request->query('theater');

        $seatsQuery = Seat::query();
        if ($filterByTheater !== null) {
            $seatsQuery->where('theater', $filterByTheater);
        }

        $movies = $seatsQuery->with('genre')->paginate(10)->withQueryString();
        return view('seats.index')->with('theater', Seat::orderBy('name')->paginate(20)->withQueryString());
    }

    public function create(): View
    {
        $newSeat = new Seat();
        return view('seats.create')
            ->with('seat', $newSeat);
    }

    public function store(SeatFormRequest $request): RedirectResponse
    {
        $newSeat = Seat::create($request->validated());
        $url = route('seats.show', ['seat' => $newSeat]);
        $htmlMessage = "Seat <a href='$url'><u>{$newSeat->row}</u></a> ({$newSeat->id}) has been created successfully!";
        return redirect()->route('seats.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Seat $seat): View
    {
        return view('seats.edit')
            ->with('seat', $seat);
    }

    public function update(SeatFormRequest $request, Seat $seat): RedirectResponse
    {
        $seat->update($request->validated());
        $url = route('seats.show', ['seat' => $seat]);
        $htmlMessage = "Seat <a href='$url'><u>{$seat->row}</u></a> ({$seat->id}) has been updated successfully!";
        return redirect()->route('seats.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Seat $seat): RedirectResponse
    {
        $seat->delete();
        $alertType = 'success';
        $alertMsg = "Seat {$seat->row}{$seat->id} has been deleted successfully!";


        return redirect()->route('seats.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Seat $seat): View
    {
        return view('seats.show')->with('seat', $seat);
    }
}
