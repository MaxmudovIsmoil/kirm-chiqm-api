<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebtorController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/users', 'UserController@index');
//Route::post('/users', 'UserController@store');
//Route::put('/users/{id}', 'UserController@update');
//Route::delete('/users/{id}', 'UserController@destroy');

Route::get('/debtor', [DebtorController::class, 'list'])->name('debtor.list');

Route::get('/user', [AuthController::class, 'list'])->name('auth.list');
