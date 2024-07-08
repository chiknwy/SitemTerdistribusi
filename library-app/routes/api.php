<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


    Route::post('/logout', [UserController::class,'logoutUser']);
    
 
    
Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [UserController::class,'logoutUser']);

        Route::get('/showlogin', [UserController::class,'showLoginUser']);
        // Book routes
        Route::get('/books', [BookController::class, 'index']);
        Route::get('/books/{id}', [BookController::class, 'show']);
        Route::post('/createBook', [BookController::class, 'storeApi']);
        Route::post('/updateBook/{id}', [BookController::class, 'updateApi']);
        Route::delete('/deleteBook/{id}', [BookController::class, 'destroyApi']);
        Route::post('/resetPassword', [UserController::class, 'sendResetLinkEmail']);
        Route::post('/reset', [UserController::class, 'reset']);
    });

//loginuser
Route::post('/login', [UserController::class, 'loginUserApi']); 
// Route::get('/showlogin', [UserController::class,'showLoginUser']);
Route::post('/register', [UserController::class,'registerUserApi']);
Route::post('/edituser/{user}', [UserController::class,'editUpdate']);
Route::delete('/delete/{user}', [UserController::class,'deleteUser']);
