<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;

Route::get('/', [UserController::class, 'index'])->name('welcome.index');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/edit-user/{id}', [UserController::class, 'update'])->name('welcome.users.update');
    Route::post('/delete-user/{id}', [UserController::class, 'destroy'])->name('welcome.users.destroy');
});



Route::get('/users', function () {
    $users = User::all();
    return response()->json($users);
});

require __DIR__.'/auth.php';
