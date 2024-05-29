<?php

namespace App\Http\Controllers;
use App\Models\Theater;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TheaterFormRequest;

class TheaterController extends Controller
{
    // Corrigir erro
    public function __construct()
    {
        $this->authorizeResource(Theater::class);
    }

    public function index(Request $request): View
    {
        $theaters = Theater::paginate(10);
        return view('theaters.index',compact('theaters'));
    }


    public function create(): View
    {
        $theater = new Theater();

        return view('theaters.create', compact('theater'));

    }


    public function  store(TheaterFormRequest $request): RedirectResponse
    {
        $newTheater = Theater::create($request->validated());

        if ($request->hasFile('photo_file')) {
            $path = $request->photo_file->store('public/theaters');
            $newTheater->photo_filename = basename($path);
            $newTheater->save();
        }


        $url = route('theaters.show', ['theater' => $newTheater]);
        $htmlMessage = "Theater <a href='$url'><u>{$newTheater->name}</u></a> ({$newTheater->abbreviation}) has been created successfully!";
        return redirect()->route('theaters.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
    }



    public function show(Theater $theater): View
    {
        return view('theaters.show', compact('theater'));
    }


    public function edit(Theater $theater): View
    {
        return view('theaters.edit', compact('theater'));
    }


    public function update(TheaterFormRequest $request, Theater $theater): RedirectResponse
    {
        $theater->update($request->validated());

        if ($request->hasFile('photo_file')) {
            // Delete previous file (if any)
            if ($theater->photo_filename &&
                Storage::fileExists('public/theaters/' . $theater->photo_filename)) {
                Storage::delete('public/theaters/' . $theater->photo_filename);
            }
            $path = $request->photo_file->store('public/theaters');
            $theater->user->photo_filename = basename($path);
            $theater->user->save();
        }


        $url = route('theaters.show', ['theater' => $theater]);
        $htmlMessage = "Theater <a href='$url'><u>{$theater->name}</u></a> ({$theater->abbreviation}) has been updated successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theater $theater): RedirectResponse
    {
        try {
            $url = route('theaters.show', ['theater' => $theater]);
            $totalScreenings = $theater->screenings()->count();
            $totalSeats = $theater->seats()->count();

            if ($totalScreenings == 0 && $totalSeats == 0) {
                $theater->delete();
                $alertType = 'success';
                $alertMsg = "Theater {$theater->name} ({$theater->abbreviation}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $screeningsStr = match (true) {
                    $totalScreenings <= 0 => "",
                    $totalScreenings == 1 => "there is 1 screening enrolled in it",
                    $totalScreenings > 1 => "there are $totalScreenings screenings enrolled in it",
                };
                $seatsStr = match (true) {
                    $totalSeats <= 0 => "",
                    $totalSeats == 1 => "it already has 1 seat",
                    $totalSeats > 1 => "it already has $totalSeats seats",
                };
                $justification = $screeningsStr && $seatsStr
                    ? "$screeningsStr and $seatsStr"
                    : "$screeningsStr$seatsStr";
                $alertMsg = "Theater <a href='$url'><u>{$theater->name}</u></a> ({$theater->id}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the theater
                            <a href='$url'><u>{$theater->name}</u></a> ({$theater->id})
                            because there was an error with the operation!";
        }
        return redirect()->route('theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    // Onde a foto pode ser nula é necessário colocar este método

    public function destroyPhoto(Theater $theater): RedirectResponse
    {
        if ($theater->user->photo_url) {
            if (Storage::fileExists('public/theaters/' . $theater->photo_filename)) {
                Storage::delete('public/theaters/' . $theater->photo_filename);
            }
            $theater->photo_filename = null;
            $theater->save();
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Photo of theater $theater {$theater->name} has been deleted.");
        }
        return redirect()->back();
    }
}
