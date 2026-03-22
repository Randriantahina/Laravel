<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::controller(TodoController::class)->prefix('todos')->name('todos.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('{id}', 'update')->name('update');
        Route::patch('{id}/toggle', 'toggle')->name('toggle');
        Route::delete('{id}', 'destroy')->name('destroy');
    });
});

require __DIR__ . '/settings.php';
