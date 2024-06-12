<?php

namespace App\Http\Controllers;
use App\Models\Movie;
use App\Models\Genre;
/*use App\Models\Theater;
use App\Models\Screening;
use Illuminate\Support\Carbon;*/
use App\Http\Requests\MovieFormRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
//use App\Http\Requests\TheaterFormRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StatisticsController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
    {
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        $genres = array_merge([null => 'Any genre'], $genres);
        $movies = Movie::all();
        $statistics = $this->getStatistics();
        return view('statistics.index', compact('movies', 'genres', 'statistics'));
    }

    public function filter(Request $request)
    {
        // Validar os dados do request
        $request->validate([
            'movie_id' => 'nullable|integer|exists:movies,id',
            'genre_code' => 'nullable|string|exists:genres,code',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        // Obter dados filtrados
        $statistics = $this->getStatistics($request->movie_id, $request->genre_code, $request->start_date, $request->end_date);
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        $genres = array_merge([null => 'Any genre'], $genres);
        $movies = Movie::all();

        // Obter os valores selecionados
        $selectedMovie = $request->movie_id ? Movie::find($request->movie_id) : null;
        $selectedGenre = $request->genre_code ? Genre::where('code', $request->genre_code)->first() : null;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return view('statistics.index', compact('movies', 'genres', 'statistics', 'selectedMovie', 'selectedGenre', 'startDate', 'endDate'));
    }

    private function getStatistics($movie_id = null, $genre_code = null, $start_date = null, $end_date = null)
    {
        $query = DB::table('tickets')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->select(DB::raw('count(tickets.id) as total_tickets'), DB::raw('sum(tickets.price) as total_revenue'));

        if ($movie_id) {
            $query->where('screenings.movie_id', $movie_id);
        }

        if ($genre_code) {
            $query->where('movies.genre_code', $genre_code);
        }

        if ($start_date) {
            $query->whereDate('screenings.date', '>=', $start_date);
        }

        if ($end_date) {
            $query->whereDate('screenings.date', '<=', $end_date);
        }

        return $query->first();
    }
}
