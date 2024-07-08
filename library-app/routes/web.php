<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\ForgotPasswordController;



// Registration routes for web
Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');

Route::post('/register', [UserController::class, 'registerUserWeb'])->name('register.web');

Route::get('/landing', [LandingController::class, 'index']);
Route::get('/', [LandingController::class, 'index']);


// Login routes for web
Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');

Route::post('/login', [UserController::class, 'loginUserWeb'])->name('login.web');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/frontpage/landing', [LandingController::class, 'index']);
    
    Route::post('/logout', [UserController::class, 'logoutUserWeb'])->name('logout');
    
    Route::get('/user', [UserController::class, 'showLoginUser'])->name('user.profile');
    Route::post('/edituser/{user}', [UserController::class, 'editUpdate'])->name('user.edit');
    Route::delete('/delete/{user}', [UserController::class, 'deleteUser'])->name('user.delete');
});

// Book routes
Route::get('/books', [BookController::class, 'index']);
Route::middleware(['auth'])->group(function () {
    Route::get('/books/create', [BookController::class, 'create']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{id}/edit', [BookController::class, 'edit']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);
});
Route::get('/profile', [BookController::class, 'profile']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [BookController::class, 'admin']);
    Route::get('/admin/create', [BookController::class, 'createUser']);
    Route::post('/admin/store', [BookController::class, 'storeUser']);
    Route::get('/admin/edit/{id}', [BookController::class, 'editUser']);
    Route::put('/admin/update/{id}', [BookController::class, 'updateUser']);
    Route::delete('/admin/delete/{id}', [BookController::class, 'deleteUser']);
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');