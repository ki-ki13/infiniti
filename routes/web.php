<?php

use App\Http\Controllers\InboundController;
use App\Http\Controllers\OutboundController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/outbound', [OutboundController::class, 'index']);
Route::get('/inbound', [InboundController::class, 'index']);