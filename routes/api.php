<?php

use App\Http\Controllers\API\StockController;
use App\Http\Controllers\ProxyController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('stock', [StockController::class, 'getData']);
Route::post('stock/create', [StockController::class, 'saveData']);
Route::put('stock/update', [StockController::class, 'updateData']);

Route::post('/proxy/getDetail', [ProxyController::class, 'getDetail']);
Route::post('/proxy/sendInbound', [ProxyController::class, 'sendInboundTask']);
Route::post('/proxy/sendOutbound', [ProxyController::class, 'sendOutboundTask']);
