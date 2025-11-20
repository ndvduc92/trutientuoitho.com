<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfflineController;
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

Route::get('/vips', [ApiController::class, 'updateVip']);
Route::get('/guilds', [ApiController::class, 'guilds']);
Route::get('/chars', [ApiController::class, 'chars']);
Route::get('/chats', [ApiController::class, 'chats']);
Route::post('/payment/success', [ApiController::class, 'paymentSuccess']);

Route::get('/trades', [ApiController::class, 'trades']);
Route::get('/tasks', [ApiController::class, 'tasks']);
Route::get('/jshop', [ApiController::class, 'jshop']);
Route::get('/ips', [ApiController::class, 'ips']);
Route::get('/ban', [ApiController::class, 'ban']);
Route::get('/sells', [ApiController::class, 'sells']);
Route::get('/boss', [ApiController::class, 'boss']);
Route::get('/logins', [ApiController::class, 'logins']);
Route::get('/refines', [ApiController::class, 'refines']);
Route::get('/loggings', [ApiController::class, 'loggings']);
Route::get('/lottery', [ApiController::class, 'lottery']);
Route::get('/bet', [ApiController::class, 'bet']);
Route::get('/offline', [OfflineController::class, 'cronjob']);

Route::get('/vip-auto', [ApiController::class, 'autoVip']);
Route::get('/search', [ApiController::class, 'search']);

Route::get('/pk', [ApiController::class, 'pk']);

Route::get('/kill', [ApiController::class, 'kill']);
Route::get('/war', [ApiController::class, 'war']);
Route::get('/remove', [ApiController::class, 'remove']);

Route::get('/online', [ApiController::class, 'online']);

Route::get('/clear', [ApiController::class, 'clear']);


Route::get('/trash', [ApiController::class, 'trash']);

