<?php

use App\Models\Purchase;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CartController;
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


require __DIR__ . '/auth.php';


// Bloquear o acesso a isto do employee
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



//Para rotas que exigem autenticação, pessoas que estejam verificadas e não estejam bloqueadas, adicionar ao carrinho não, por exemplo
Route::middleware(['auth', 'verified', 'can:no-blocked'])->group(function () {



    // para rotas de admin
    Route::middleware('can:admin')->group(function () {

        Route::view('/dashboard', 'dashboard')->name('dashboard');
        Route::resource("genres", GenreController::class);
        Route::resource('movies', MovieController::class);
        Route::delete('movies/{movie}/photo', [MovieController::class, 'destroyPhoto'])->name('movies.photo.destroy')->can('update', 'movie');
        Route::resource("theaters", TheaterController::class);
        Route::delete('movies/{theater}/photo', [MovieController::class, 'destroyPhoto'])->name('theaters.photo.destroy')->can('update', 'theater');
        Route::resource("users", UserController::class);
        Route::resource("customers", CustomerController::class);
        Route::get('configurations/edit', [ConfigurationController::class, 'edit'])->name('configurations.edit');
        Route::put('configurations', [ConfigurationController::class, 'update'])->name('configurations.update');
        Route::resource('purchases', PurchaseController::class);
        Route::get('statistics', [StatisticsController::class, 'totaisGerais'])->name('statistics.index');
        Route::patch('users/{user}/block', [UserController::class, 'updatedBlock'])->name('users.updatedBlock');
        Route::patch('customers/{user}/block', [UserController::class, 'updatedBlock'])->name('customers.updatedBlock');
    });
});


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


Route::get('/', [MovieController::class, 'showMovies'])->name('home');
Route::get('showMovies', [MovieController::class, 'showMovies'])->name('movies.showMovies');
Route::get("screenings\{screening}\showcase", [ScreeningController::class, 'showScreening'])->name('screenings.showcase');




Route::get('/purchase/history', [PurchaseController::class, 'history'])->name('purchase.history');
Route::get('/purchase/{purchase}', [PurchaseController::class, 'show'])->name('purchase.show');
Route::get('/purchase/{purchase}/receipt', [PurchaseController::class, 'getReceipt'])->name('purchase.getReceipt');


Route::get('screenings/management', [ScreeningController::class, 'management'])->name('screenings.management')->middleware('auth');
Route::get('/my-screenings', [ScreeningController::class, 'myScreenings'])->name('myScreenings');




Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);
Route::get('send-email-pdf', [PDFController::class, 'index']);
