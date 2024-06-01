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



/*use App\Models\Genre;
use App\Models\User;
use App\Models\Theater;*/
use App\Models\Movie;

Route::middleware('auth')->group(function () {
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
});


Route::view('/dashboard', 'dashboard')->name('dashboard');

require __DIR__ . '/auth.php';

//Route::view('/', 'home')->name('home');


Route::get('/', [MovieController::class, 'showMovies'])->name('home');
Route::get('showMovies', [MovieController::class, 'showMovies'])->name('movies.showMovies');
Route::resource('movies', MovieController::class);
Route::delete('movies/{movie}/photo', [MovieController::class, 'destroyPhoto'])->name('movies.photo.destroy')->can('update', 'movie'); //Não sei se esta rota está a fazer alguma coisa
Route::resource("genres", GenreController::class);
Route::resource("theaters",TheaterController::class);
Route::resource("user", UserController::class);
Route::resource("costumers", CustomerController::class);
