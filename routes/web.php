<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController as O;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', [O::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('order')->name('order.')->group(function () {
    Route::get('/', [O::class, 'create'])->name('create');
    Route::post('/', [O::class, 'store'])->name('store');
    Route::get('/edit/{order}', [O::class, 'edit'])->name('edit');
    Route::put('/edit/{order}', [O::class, 'update'])->name('update');
    Route::delete('/delete/{order}', [O::class, 'destroy'])->name('destroy');
});