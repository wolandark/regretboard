<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegretController;

Route::get('/', [RegretController::class, 'index'])->name('regrets.index');
Route::get('/regrets/{regret}', [RegretController::class, 'show'])->name('regrets.show');
Route::post('/regrets', [RegretController::class, 'store'])->name('regrets.store');
Route::get('/regrets/{regret}/edit', [RegretController::class, 'edit'])->name('regrets.edit');
Route::put('/regrets/{regret}', [RegretController::class, 'update'])->name('regrets.update');
Route::delete('/regrets/{regret}', [RegretController::class, 'destroy'])->name('regrets.destroy');
Route::post('/regrets/{regret}/comments', [RegretController::class, 'comment'])->name('regrets.comment');
Route::get('/regrets/{regret}/comments/{commentId}/edit', [RegretController::class, 'editComment'])->name('regrets.comments.edit');
Route::put('/regrets/{regret}/comments/{commentId}', [RegretController::class, 'updateComment'])->name('regrets.comments.update');
Route::delete('/regrets/{regret}/comments/{commentId}', [RegretController::class, 'destroyComment'])->name('regrets.comments.destroy');
