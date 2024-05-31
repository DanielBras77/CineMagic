<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Theater;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SeatFormRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SeatController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Seat::class);
    }

    public function index(): View
    {
        $theaters = Theater::orderBy('name')->pluck('name', 'id')->toArray();
        $theaters = array_merge([null => 'Any theater'], $theaters);
        $filterByTheater = $request->query('theater');


        return view('seats.index')
            ->with('theater', Seat::orderBy('name')->paginate(20)->withQueryString());
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
        $htmlMessage = "Seat <a href='$url'><u>{$newSeat->name}</u></a> ({$newSeat->code}) has been created successfully!";
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
        $htmlMessage = "Seat <a href='$url'><u>{$seat->name}</u></a> ({$seat->code}) has been updated successfully!";
        return redirect()->route('seats.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Seat $seat): RedirectResponse
    {
        try {
            $url = route('seats.show', ['seat' => $seat]);

            $totalMovies = $seat->movies()->count();
            if ($totalMovies == 0) {
                $seat->delete();
                $alertType = 'success';
                $alertMsg = "Seat {$seat->name} ({$seat->code}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalMovies <= 0 => "",
                    $totalMovies == 1 => "there is 1 movie in the seat",
                    $totalMovies > 1 => "there are $totalMovies movies in the seat",
                };
                $alertMsg = "Seat <a href='$url'><u>{$seat->name}</u></a> ({$seat->code}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the seat
                            <a href='$url'><u>{$seat->name}</u></a> ({$seat->code})
                            because there was an error with the operation!";
        }
        return redirect()->route('seats.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Seat $seat): View
    {
        return view('seats.show')->with('seat', $seat);
    }
}
