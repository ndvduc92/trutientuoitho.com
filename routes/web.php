<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'home']);

Route::get('/tin-tuc', [HomeController::class, 'news']);

Route::get('/tin-tuc/{slug}', [HomeController::class, 'new']);

Route::get('/tai-game', [HomeController::class, 'download']);

Route::get('/thu-vien', [HomeController::class, 'library']);

Route::get('/hoat-dong', [HomeController::class, 'event']);

Route::get('/huong-dan', [HomeController::class, 'wiki']);

Route::get('/chi-so-thang-thien', [HomeController::class, 'chiso']);

