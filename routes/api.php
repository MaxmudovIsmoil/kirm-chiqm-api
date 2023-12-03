<?php


use App\Enums\TokenAbility;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebtorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DebtorDetailController;

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

    Route::get('profile', [AuthController::class, 'profile']);

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

    Route::prefix('currency')->group(function() {
        Route::get('/', [CurrencyController::class, 'index']);
        Route::post('/create', [CurrencyController::class, 'store']);
        Route::put('/update/{id}', [CurrencyController::class, 'update']);
        Route::delete('/delete/{id}', [CurrencyController::class, 'destroy']);
    });

    Route::post('refreshToken', [AuthController::class, 'refreshToken'])
        ->middleware(['ability:'.TokenAbility::ISSUE_ACCESS_TOKEN->value]);

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

