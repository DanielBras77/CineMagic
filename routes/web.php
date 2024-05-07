<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DisciplineController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::view('/', 'home')->name('home');
