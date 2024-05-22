<?php

use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\Genre;

Route::view('/', 'home')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
});


Route::view('/dashboard', 'dashboard')->name('dashboard');

require __DIR__ . '/auth.php';


Route::resource('movie', MovieController::class);
Route::resource("genres", GenreController::class);
//Route::resource("user", UserController::class);
Route::resource("costumers", CustomerController::class);
