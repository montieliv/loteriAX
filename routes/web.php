<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\VentaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('lotteries', LotteryController::class);

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/random', function () {
    return view('numbers');
});

Route::get('/showActuals', [LotteryController::class, 'actuals']);

Route::post('/lottery/sell', [LotteryController::class, 'sell'])->name('lottery.sell');

Route::get('/', [VentaController::class, 'showCardSold'])->name('venta.showCardSold');

Route::get('/Sorteo', [LotteryController::class, 'sorteo']);

Route::get('/CerrarSorteo/{id}/{cardId}/{priceID}', [LotteryController::class, 'update']);


