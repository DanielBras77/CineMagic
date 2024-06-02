<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;



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

//Route::view('/', 'home')->name('home');


Route::get('/', [MovieController::class, 'showMovies'])->name('home');
Route::get('showMovies', [MovieController::class, 'showMovies'])->name('movies.showMovies');
Route::resource("genres", GenreController::class);
Route::resource('movies', MovieController::class);
Route::delete('movies/{movie}/photo', [MovieController::class, 'destroyPhoto'])->name('movies.photo.destroy')->can('update', 'movie');
Route::resource("theaters",TheaterController::class);
Route::delete('movies/{theater}/photo', [MovieController::class, 'destroyPhoto'])->name('theaters.photo.destroy')->can('update', 'theater');
Route::resource("user", UserController::class);
Route::resource("costumers", CustomerController::class);
