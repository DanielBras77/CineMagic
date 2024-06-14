<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Theater;
use App\Models\Purchase;
use Illuminate\View\View;
use App\Models\Statistics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SeatFormRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StatisticsController extends Controller
{

    //Saber quantos movies existem por ano

    public function totaisGerais(){
        $total_genres = Genre::count();
        /**/
        return view('statistics.totais', compact('total_genres'));
    }


    public function PurchasesTotaisFilter(Request $request){

        $filterByMonth = $request->month??"";
        $filterByYear = $request->year??"";

        $purchasesQuery = Purchase::query();

        if($filterByMonth){
            $purchasesQuery->whereMonth('date', $filterByMonth);
        }

        if($filterByYear){
            $purchasesQuery->whereYear('date', $filterByYear);
        }

        $purchases = $purchasesQuery->get();
        $totalPurchases = $purchasesQuery->count();
        $totalPrices = $purchases->sum('total_price');

        // Chamar vista return view('statistics.totais', compact('total_genres'));

    }

    public function TotalMoviesByGenre(){

       $genres = Genre::withCount('movies')->all();

        // Chamar vista e passar variável

        /*
            Na vista:

            @foreach($genres as $genre)
                <div> {{$genre->name}} - {{$genre->movies_count}} </div>

            @endforeach
        */
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
