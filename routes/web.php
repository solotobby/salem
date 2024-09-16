<?php

use App\Http\Controllers\AdvisersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
    Route::get('adviser/create', [AdvisersController::class, 'create'])->name('adviser.create');
    Route::post('adviser/store', [AdvisersController::class, 'store'])->name('adviser.store');
    Route::get('adviser/{id}', [AdvisersController::class, 'show']);
   

});

require __DIR__.'/auth.php';
