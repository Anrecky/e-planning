<?php

use App\Http\Controllers\RenstraController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('dasbor', function () {
        return view('app.dashboard', ['title' => 'Dasbor']);
    })->name('admin.dashboard');
    Route::prefix('renstra')->group(function () {
        Route::get('visi', [RenstraController::class, 'visi'])->name('renstra.visi');
    });
});
