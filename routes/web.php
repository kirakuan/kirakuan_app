<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reservation\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/reservation', [ReservationController::class, "index"]);

// フォーム
Route::get('/reservation/create', [ReservationController::class, "create"]);
Route::post('/reservation/create/comfirm', [ReservationController::class, "create_comfirm"]);
Route::post('/reservation/create/comfirmed', [ReservationController::class, "comfirmed"]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('auth')->group(function () {
        Route::get('/reservation', [ReservationController::class, "auth_index"]);
        // Route::post('/reservation/create', [ReservationController::class, "create"]);
    });
});

require __DIR__.'/auth.php';
