<?php

namespace App\Http\Controllers;
//use App\Models\Movie;
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
use Carbon\Carbon;

class StatisticsController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
    {
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        $genres = array_merge([null => 'Any genre'], $genres);
        $filterByYear =  Screening::where('date', '>=', Carbon::today())
        ->where('date', '<=', Carbon::today()->addWeeks(2))->pluck('movie_id')->unique();
        $filterByGenre = $request->query('genre');

        $query = DB::table('tickets')
        ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
        ->join('movies', 'screenings.movie_id', '=', 'movies.id')
        ->select(DB::raw('count(tickets.id) as total_tickets'), DB::raw('sum(tickets.price) as total_revenue'));
        if ($filterByGenre !== null) {
            $query->where('genre_code', $filterByGenre);
        }


        //$statistics = $this->getStatistics();
        return view('statistics.index', compact( 'genres', 'statistics'));
    }

    public function filter(Request $request)
    {
        // Obter dados filtrados
        $statistics = $this->getStatistics($request->genre_code);
        $genres = Genre::orderBy('name')->pluck('name', 'code')->toArray();
        $genres = array_merge([null => 'Any genre'], $genres);
        $date = Carbon::now()->subMonths(6);


        $selectedGenreByUser = $request->genre_code ? Genre::where('code', $request->genre_code)->first() : null;

        return view('statistics.index', compact( 'genres', 'statistics', 'selectedGenreByUser', 'startDateByUser', 'endDateByUser'));
    }

    private function getStatistics($genre_code = null, $start_date = null, $end_date = null)
    {
       /* $query = DB::table('purchases')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->select(DB::raw('count(purchases.id) as total_tickets'), DB::raw('sum(purchases.price) as total_revenue'));*/

            $query = DB::table('tickets')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->select(DB::raw('count(tickets.id) as total_tickets'), DB::raw('sum(tickets.price) as total_revenue'));

        if ($genre_code) {
            $query->where('movies.genre_code', $genre_code);
        }

        return $query->first();
    }
}
