<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GenreFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GenreController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Genre::class);
    }

    public function index(): View
    {
        return view('genres.index')
            ->with('genres', Genre::orderBy('name')->paginate(20)->withQueryString());
    }

    public function create(): View
    {
        $newGenre = new Genre();
        return view('genres.create')
            ->with('genre', $newGenre);
    }

    public function store(GenreFormRequest $request): RedirectResponse
    {
        $newGenre = Genre::create($request->validated());
        $url = route('genres.show', ['genre' => $newGenre]);
        $htmlMessage = "Genre <a href='$url'><u>{$newGenre->name}</u></a> ({$newGenre->code}) has been created successfully!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Genre $genre): View
    {
        return view('genres.edit')
            ->with('genre', $genre);
    }

    public function update(GenreFormRequest $request, Genre $genre): RedirectResponse
    {
        $genre->update($request->validated());
        $url = route('genres.show', ['genre' => $genre]);
        $htmlMessage = "Genre <a href='$url'><u>{$genre->name}</u></a> ({$genre->code}) has been updated successfully!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        try {
            $url = route('genres.show', ['genre' => $genre]);

            $totalMovies = $genre->movies()->count();
            if ($totalMovies == 0) {
                $genre->delete();
                $alertType = 'success';
                $alertMsg = "Genre {$genre->name} ({$genre->code}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalMovies <= 0 => "",
                    $totalMovies == 1 => "there is 1 movie in the genre",
                    $totalMovies > 1 => "there are $totalMovies movies in the genre",
                };
                $alertMsg = "Genre <a href='$url'><u>{$genre->name}</u></a> ({$genre->code}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the genre
                            <a href='$url'><u>{$genre->name}</u></a> ({$genre->code})
                            because there was an error with the operation!";
        }
        return redirect()->route('genres.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Genre $genre): View
    {
        return view('genres.show')->with('genre', $genre);
    }
}
