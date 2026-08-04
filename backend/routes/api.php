<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


//Route::get('/users', [UserController::class, 'index']);
//Route::post('/users', [UserController::class, 'store']);

Route::apiResource('/users', UserController::class); // Cadastra as 5 rotas de forma automática (index, store, show, update, destroy)
