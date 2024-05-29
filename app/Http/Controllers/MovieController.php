<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MovieFormRequest;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{

    public function index(Request $request): View
    {
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        $genres = array_merge([null => 'Any genre'], $genres);
        $filterByGenre = $request->query('genre');
        $filterByTitle = $request->query('title');
        $filterByYear = $request->query('year');

        $moviesQuery = Movie::query();
        if ($filterByGenre !== null) {
            $moviesQuery->where('genre_code', $filterByGenre);
        }

        if ($filterByTitle !== null) {
            $moviesQuery->where('title', 'like', "%$filterByTitle%");
        }

        if($filterByYear !== null){
            $moviesQuery->where('year', $filterByYear);
        }

        $movies = $moviesQuery->with('genre')->paginate(10)->withQueryString();
        return view('movies.index',compact('movies', 'genres', 'filterByGenre', 'filterByTitle', 'filterByYear'));
    }

    public function showMovies(Request $request): View
    {
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        $genres = array_merge([null => 'Any genre'], $genres);
        $filterByGenre = $request->query('genre');
        $filterByTitle = $request->query('title');
        $filterByYear = $request->query('year');

        $moviesQuery = Movie::query();

        // Ver o between
        $movies_id = Screening::where('date', '>=', Carbon::today())
        ->where('date', '<=', Carbon::today()->addWeeks(2))->pluck('movie_id')->unique();

        $moviesQuery->whereIntegerInRaw('id', $movies_id);

        if ($filterByGenre !== null) {
            $moviesQuery->where('genre_code', $filterByGenre);
        }

        if ($filterByTitle !== null) {
            $moviesQuery->where('title', 'like', "%$filterByTitle%");
        }

        if($filterByYear !== null){
            $moviesQuery->where('year', $filterByYear);
        }

        $movies = $moviesQuery->with('genre')->paginate(10)->withQueryString();
        return view('movies.showcase',compact('movies', 'genres', 'filterByGenre', 'filterByTitle', 'filterByYear'));
    }


    public function create(): View
    {
        $movie = new Movie();
        $genres = Genre::orderBy("name")->pluck('name', 'code')->toArray();
        return view('movies.create', compact('movie', 'genres'));

    }


    public function store(MovieFormRequest $request): RedirectResponse
    {
        $newMovie = Movie::create($request->validated());

        if ($request->hasFile('photo_file')) {
            $path = $request->photo_file->store('public/posters');
            $newMovie->poster_filename = basename($path);
            $newMovie->save();
        }


        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Movie <a href='$url'><u>{$newMovie->title}</u></a> ({$newMovie->id}) has been created successfully!";
        return redirect()->route('movies.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
    }



    public function show(Movie $movie): View
    {
        $genres = Genre::orderBy("name")->pluck('name', 'code')->toArray();
        return view('movies.show', compact('movie','genres'));
    }


    public function edit(Movie $movie): View
    {
        $genres = Genre::orderBy("name")->pluck('name', 'code')->toArray();
        return view('movies.edit', compact('movie', 'genres'));
    }


    public function update(MovieFormRequest $request, Movie $movie): RedirectResponse
    {
        $movie->update($request->validated());

        if ($request->hasFile('photo_file')) {
            // Delete previous file (if any)
            if ($movie->poster_filename &&
                Storage::fileExists('public/posters/' . $movie->poster_filename)) {
                Storage::delete('public/posters/' . $movie->poster_filename);
            }
            $path = $request->photo_file->store('public/posters');
            $movie->user->poster_filename = basename($path);
            $movie->user->save();
        }


        $url = route('movies.show', ['movie' => $movie]);
        $htmlMessage = "Movie <a href='$url'><u>{$movie->title}</u></a> ({$movie->id}) has been updated successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        try {
            $url = route('movies.show', ['movie' => $movie]);
            $totalScreenings = $movie->screenings()->count();

            if ($totalScreenings == 0) {
                $movie->delete();
                $alertType = 'success';
                $alertMsg = "Movie {$movie->title} ({$movie->id}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalScreenings <= 0 => "",
                    $totalScreenings == 1 => "there is 1 screening enrolled in it",
                    $totalScreenings > 1 => "there are $totalScreenings screenings enrolled in it",
                };

                $alertMsg = "Movie <a href='$url'><u>{$movie->title}</u></a> ({$movie->id}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the movie
                            <a href='$url'><u>{$movie->title}</u></a> ({$movie->id})
                            because there was an error with the operation!";
        }
        return redirect()->route('movies.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    // Onde a foto pode ser nula é necessário colocar este método

    public function destroyPhoto(Movie $movie): RedirectResponse
    {
        if ($movie->user->photo_url) {
            if (Storage::fileExists('public/posters/' . $movie->poster_filename)) {
                Storage::delete('public/posters/' . $movie->poster_filename);
            }
            $movie->poster_filename = null;
            $movie->save();
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "Photo of movie $movie {$movie->title} has been deleted.");
        }
        return redirect()->back();
    }
}
