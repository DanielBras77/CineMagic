<?php

use App\Models\Purchase;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ConfigurationController;



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//Para rotas que exigem autenticação, adicionar ao carrinho não, por exemplo
Route::middleware(['auth', 'verified', 'can:no-blocked'])->group(function () {



    // para rotas de admin
    Route::middleware('can:admin')->group(function () {
        //statistics fica aqui

    });
});
*/


require __DIR__ . '/auth.php';

Route::view('/dashboard', 'dashboard')->name('dashboard');
Route::get('/', [MovieController::class, 'showMovies'])->name('home');
Route::get('showMovies', [MovieController::class, 'showMovies'])->name('movies.showMovies');
Route::get("screenings\{screening}\showcase", [ScreeningController::class, 'showScreening'])->name('screenings.showcase');
Route::resource("genres", GenreController::class);
Route::resource('movies', MovieController::class);
Route::delete('movies/{movie}/photo', [MovieController::class, 'destroyPhoto'])->name('movies.photo.destroy')->can('update', 'movie');
Route::resource("theaters", TheaterController::class);
Route::delete('movies/{theater}/photo', [MovieController::class, 'destroyPhoto'])->name('theaters.photo.destroy')->can('update', 'theater');
Route::resource("users", UserController::class);
Route::resource("customers", CustomerController::class);


Route::patch('users/{user}/block', [UserController::class, 'updatedBlock'])->name('users.updatedBlock');
Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

Route::get('configurations/edit', [ConfigurationController::class, 'edit'])->name('configurations.edit');
Route::put('configurations', [ConfigurationController::class, 'update'])->name('configurations.update');

Route::get('send-email-pdf', [PDFController::class, 'index']);

Route::middleware('can:use-cart')->group(function () {
    // Add a screening to the cart:
    Route::post('cart/{screening}', [CartController::class, 'addToCart'])->name('cart.add');
    // Remove a screening from the cart:
    Route::delete('cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Confirm (store) the cart and save screenings registration on the database:
    Route::post('cart', [CartController::class, 'confirm'])->name('cart.confirm');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
});




Route::get('teste/{purchase}', function (Purchase $purchase) {
    return view('purchases.receipt', compact('purchase'));
});


//Route::get("tickets\{ticket}\showcase", [ticketController::class, 'showcase'])->name('Tickets'.showcase);
//Route::get('statistics', [StatisticsController::class, 'show'])->name('statistics.show');
Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
Route::post('/statistics/filter', [StatisticsController::class, 'filter'])->name('statistics.filter');
//Route::post('statistics/filter', [StatisticsController::class, 'filter'])->name('statistics.filter');


//para apagar foto de perfil do customer
Route::delete('customers/{customer}/photo', [CustomerController::class, 'destroyPhoto'])
    ->name('customers.photo.destroy');
