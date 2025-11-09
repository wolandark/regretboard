<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegretController;

Route::get('/', [RegretController::class, 'index'])->name('regrets.index');
Route::get('/regrets/{regret}', [RegretController::class, 'show'])->name('regrets.show');
Route::post('/regrets', [RegretController::class, 'store'])->name('regrets.store');
Route::post('/regrets/{regret}/comments', [RegretController::class, 'comment'])->name('regrets.comment');
