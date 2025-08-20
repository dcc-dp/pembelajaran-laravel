<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('cek-ongkir', [OngkirController::class, 'index']);
Route::get('get-kota/{id}', [OngkirController::class, 'getKota']);
Route::get('get-kec/{id}', [OngkirController::class, 'getKec']);
Route::post('cek-rong', [OngkirController::class, 'cekRong']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified'])->get('/dashboard',[DashboardController::class,
    'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
