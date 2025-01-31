<?php

use App\Http\Controllers\Api\MarketingController;
use App\Http\Controllers\Api\PenjualanController;
use App\Models\Penjualan;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// API untuk Penjualan RESTFUL API
Route::get('/penjualan', [PenjualanController::class, 'index']);
Route::post('/penjualan', [PenjualanController::class, 'store']);
Route::put('/penjualan/{id}', [PenjualanController::class, 'update']);
Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);
Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy']);


// API untuk marketing
Route::get('/marketing', [MarketingController::class, 'index']);
Route::get('/marketing/{id}', [MarketingController::class, 'show']);

// API untuk mendapatkan komisi
Route::get('/comission', [PenjualanController::class, 'getComission']);
