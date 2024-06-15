<?php

namespace App\Http\Controllers;
//use App\Models\Movie;

use App\Models\Genre;
use App\Charts\Generos;
use App\Charts\Purchase_graph;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{

    public function totaisGerais(Request $request): View
    {
        $total_genres = Genre::count();

        $numAdminsAtivos = User::where('type', 'A')
            ->where('blocked', 0)
            ->whereNull('deleted_at')
            ->count();

        $numEmployeesAtivos = User::where('type', 'E')
            ->where('blocked', 0)
            ->whereNull('deleted_at')
            ->count();

        $numCustomersAtivos = User::where('type', 'C')
            ->where('blocked', 0)
            ->whereNull('deleted_at')
            ->count();

        $numDeUserBloqueados = User::where('blocked', '1')
            ->count();


        $filterByYear = $request->year ?? "";

        $purchasesQuery = Purchase::query();

        if ($filterByYear) {
            $purchasesQuery->whereYear('date', $filterByYear);
        }

        $purchases = $purchasesQuery->get();
        $totalPurchases = $purchasesQuery->count();
        $totalPrices = $purchases->sum('total_price');

        // Pie chart
        $genreCounts = DB::table('genres')
            ->join('movies', 'genres.code', '=', 'movies.genre_code')
            ->select('genres.name', DB::raw('count(movies.id) as count'))
            ->groupBy('genres.name')
            ->get();

        $colors = [];
        $genresChart = new Generos;

        foreach ($genreCounts as $genre) {
            $red = mt_rand(0, 255);
            $green = mt_rand(0, 255);
            $blue = mt_rand(0, 255);
            $colors[] = "rgb($red, $green, $blue)";
        }

        if ($genreCounts->isNotEmpty()) {
            $genresChart->labels($genreCounts->pluck('name')->toArray())
                ->dataset('Total', 'pie', $genreCounts->pluck('count')->toArray())
                ->backgroundColor($colors);
        } else {

            $genresChart->labels(['No Data'])->dataset('Total', 'pie', [1])->backgroundColor(['rgb(0, 0, 255)']);
        }

        // Bar Chart

        $vendasMensais = DB::table('purchases')
            ->select(
                DB::raw('YEAR(date) as year'),
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(total_price) as total_sales')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $labels = [];
        $vendas = [];

        foreach ($vendasMensais as $vendasPorMes) {
            $monthName = Carbon::create()->month($vendasPorMes->month)->format('F');
            $labels[] = "{$monthName} {$vendasPorMes->year}";
            $vendas[] = $vendasPorMes->total_sales;
        }

        $colors = [];
        foreach ($vendas as $venda) {
            $red = mt_rand(0, 255);
            $green = mt_rand(0, 255);
            $blue = mt_rand(0, 255);
            $colors[] = "rgb($red, $green, $blue)";
        }

        $purchasesChart = new Purchase_graph;
        $purchasesChart->labels($labels)
            ->dataset('Total', 'bar', $vendas)
            ->backgroundColor($colors);


        return view('statistics.index', compact('total_genres', 'numAdminsAtivos', 'numEmployeesAtivos', 'numCustomersAtivos', 'numDeUserBloqueados', 'totalPurchases', 'totalPrices', 'genresChart','purchasesChart'));
    }
}
