<?php

use App\Http\Controllers\AkunApiController;
use App\Http\Controllers\RuteApiController;
use App\Http\Controllers\TransportasiApiController;
use App\Http\Controllers\VerifikasiApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//------------------- RUTE --------------
route::get('/rute',[RuteApiController::class, 'index']);
route::get('/rute/{id}',[RuteApiController::class, 'show']);

//------------------ AKUN --------------------
route::get('/akun',[AkunApiController::class, 'index']);
route::post('/akun',[AkunApiController::class, 'store']);
Route::patch('/akun/{id}', [AkunApiController::class, 'update']);
Route::delete('/akun/{id}', [AkunApiController::class, 'destroy']);

//------------------ VERIFIKASI ------------------------
Route::get('/verifikasi', [VerifikasiApiController::class, 'index']);
Route::get('/verifikasi/{id}', [VerifikasiApiController::class, 'show']);
Route::post('/verifikasi', [VerifikasiApiController::class, 'store']);
Route::post('/verifikasi/update-kursi', [VerifikasiApiController::class, 'i']);
Route::patch('/verifikasi/{id}', [VerifikasiApiController::class, 'update']);
Route::delete('/verifikasi/{id}', [VerifikasiApiController::class, 'destroy']);

//------------------- ARMADA ---------------------------
route::get('/transportasi',[TransportasiApiController::class, 'index']);
route::get('/transportasi/{id}',[TransportasiApiController::class, 'show']);