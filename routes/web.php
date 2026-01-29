<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [KaseController::class, 'publicIndex'])->name('home');
Route::get('/track', [KaseController::class, 'track'])->name('track');

Route::middleware(['auth', 'verified'])->group(function () {
    

    Route::get('/dashboard', [KaseController::class, 'index'])->name('dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::get('/kases/create', [KaseController::class, 'create'])->name('kases.create');
        Route::post('/kases', [KaseController::class, 'store'])->name('kases.store');
    });

    Route::get('/kases/{id}', [KaseController::class, 'show'])->name('kases.show');
    Route::put('/kases/{id}/update', [KaseController::class, 'update'])->name('kases.update');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
        Route::patch('/users/{id}/role', [UserController::class, 'updateRole'])->name('admin.users.role');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.delete');
});


    Route::resource('inspections', InspectionController::class);
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
});

require __DIR__.'/auth.php';