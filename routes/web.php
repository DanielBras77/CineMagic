<?php

use Illuminate\Support\Facades\Route;
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



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::view('/dashboard', 'dashboard')->name('dashboard');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/


require __DIR__ . '/auth.php';


Route::get('/', [MovieController::class, 'showMovies'])->name('home');
Route::get('showMovies', [MovieController::class, 'showMovies'])->name('movies.showMovies');
Route::get("screenings\{screening}\showcase", [ScreeningController::class, 'showScreening']) -> name('screenings.showcase');
Route::resource("genres", GenreController::class);
Route::resource('movies', MovieController::class);
Route::delete('movies/{movie}/photo', [MovieController::class, 'destroyPhoto'])->name('movies.photo.destroy')->can('update', 'movie');
Route::resource("theaters",TheaterController::class);
Route::delete('movies/{theater}/photo', [MovieController::class, 'destroyPhoto'])->name('theaters.photo.destroy')->can('update', 'theater');
Route::resource("users", UserController::class);
Route::resource("customers", CustomerController::class);

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

//Route::get('statistics', [StatisticsController::class, 'show'])->name('statistics.show');


