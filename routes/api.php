<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebtorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DebtorDetailController;
use App\Http\Controllers\MoneyDifferenceController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('debtor')->group(function() {
        Route::get('/', [DebtorController::class, 'index']);
        Route::post('/create', [DebtorController::class, 'store']);
        Route::post('/update', [DebtorController::class, 'update']);
        Route::delete('/delete/{id}', [DebtorController::class, 'destroy']);
    });

    Route::prefix('debtor-detail')->group(function() {
        Route::get('/{id}', [DebtorDetailController::class, 'index']);
        Route::post('/create', [DebtorDetailController::class, 'store']);
        Route::put('/update/{id}', [DebtorDetailController::class, 'update']);
        Route::delete('/delete/{id}', [DebtorDetailController::class, 'destroy']);
    });

    // ? chala
    Route::prefix('money-differance')->group(function() {
        Route::get('/', [MoneyDifferenceController::class, 'index']);
        Route::post('/create', [MoneyDifferenceController::class, 'store']);
        Route::put('/update/{id}', [MoneyDifferenceController::class, 'update']);
        Route::delete('/delete/{id}', [MoneyDifferenceController::class, 'destroy']);
    });

    Route::prefix('currency')->group(function() {
        Route::get('/', [CurrencyController::class, 'index']);
        Route::post('/create', [CurrencyController::class, 'store']);
        Route::put('/update/{id}', [CurrencyController::class, 'update']);
        Route::delete('/delete/{id}', [CurrencyController::class, 'destroy']);
    });


    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
