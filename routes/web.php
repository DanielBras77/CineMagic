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
/*use App\Models\Genre;
use App\Models\User;*/

Route::view('/', 'home')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
});


Route::view('/dashboard', 'dashboard')->name('dashboard');

require __DIR__ . '/auth.php';


Route::resource("genres", GenreController::class);
