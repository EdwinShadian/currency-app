<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CurrencyController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/currency')->group(function () {
    Route::get('/', [CurrencyController::class, 'index'])->name('api.currency.index');
    Route::get('/rate', [CurrencyController::class, 'rate'])->name('api.currency.rate');
    Route::post('/convert', [CurrencyController::class, 'convert'])->name('api.currency.convert');
});
