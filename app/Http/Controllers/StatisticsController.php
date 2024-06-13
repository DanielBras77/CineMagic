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
/*<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use App\Models\Price;
use App\Models\Order_item;
use App\Models\Tshirt_image;
use App\Models\User;
use App\Charts\Orders;
use App\Charts\Categories;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlyTotalPrices = Order::selectRaw('SUM(total_price) as total_price_sum, DATE_FORMAT(date, "%Y-%m") as month')
            ->where('status', '!=', 'canceled')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('total_price_sum');

        $currentMonth = Carbon::now();
        $startMonth = Carbon::create(2020, 8, 1);

        $monthsCollection = Collection::make();

        while ($startMonth->lessThanOrEqualTo($currentMonth)) {
            $monthsCollection->push($startMonth->format('Y-m'));
            $startMonth->addMonth();
        }

        $Orderschart = new Orders;
        $Orderschart->labels($monthsCollection)
            ->dataset('Total Earnings','bar' ,$monthlyTotalPrices)
            ->backgroundColor('rgb(54, 162, 235)');


        $totalSales = Order_item::join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
            ->leftJoin('categories', 'tshirt_images.category_id', '=', 'categories.id')
            ->selectRaw('IFNULL(categories.name, "Custom Tshirts") AS category, SUM(order_items.qty) AS total_sales')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'closed')
            ->groupBy('category')
            ->get();
        $categories = $totalSales->pluck('category');
        $sales = $totalSales->pluck('total_sales');

        foreach ($sales as $sale) {
            $red = mt_rand(0, 255);
            $green = mt_rand(0, 255);
            $blue = mt_rand(0, 255);

            $colors[] = "rgb($red, $green, $blue)";
        }

        $categoriesChart= new Categories;
        $categoriesChart->labels($categories)
            ->dataset('Sales','pie',$sales)
            ->backgroundColor($colors)
            ->options([
                'scales' => [
                    'y' => [
                        'ticks' => [
                            'display' => false
                        ]
                    ]
                ]
            ]);

        $prices=Price::first();

        $numAdmins = User::where('user_type', 'A')
            ->where('blocked', 0)
            ->whereNull('deleted_at')
            ->count();

        $numEmployees = User::where('user_type', 'E')
            ->where('blocked', 0)
            ->whereNull('deleted_at')
            ->count();

        $numCustomers = User::where('user_type', 'C')
            ->where('blocked', 0)
            ->whereNull('deleted_at')
            ->count();

        $numBlocked = User::where('blocked', 1)
            ->whereNull('deleted_at')
            ->count();

        $numCategories = Category::whereNull('deleted_at')->count();

        $numSales = $sales->sum();

        return view('dashboard.index', compact('Orderschart','categoriesChart','prices','numAdmins','numEmployees','numCustomers','numBlocked','numCategories', 'numSales'));
    }
}
*/
