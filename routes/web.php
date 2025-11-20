<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangeEmailController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\GiftcodeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngameController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KnbController;
use App\Http\Controllers\LoggingController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShakeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VipController;
use App\Http\Controllers\WarController;
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

//Route::get('/tin-tuc', [HomeController::class, 'news']);

//Route::get('/tin-tuc/{slug}', [HomeController::class, 'new']);

Route::get('/tai-game', [HomeController::class, 'download']);

//Route::get('/thu-vien', [HomeController::class, 'library']);

//Route::get('/hoat-dong', [HomeController::class, 'event']);

//Route::get('/huong-dan', [HomeController::class, 'wiki']);

//Route::get('/chi-so-thang-thien', [HomeController::class, 'chiso']);

Route::group(['prefix' => 'account'], function () {
    Route::get('/dang-ky', [AuthController::class, 'signup']);
    Route::post('/dang-ky', [AuthController::class, 'signupPost']);
    Route::get('/reload-captcha', [AuthController::class, 'reloadCaptcha']);

    Route::post('/dang-nhap', [AuthController::class, 'signinPost']);
    Route::get('/dang-nhap', [AuthController::class, 'signin'])->name("login");

    Route::get('/quen-mat-khau', [PasswordController::class, 'forgotPasswordGet']);
    Route::post('/quen-mat-khau', [PasswordController::class, 'forgotPasswordPost']);
    Route::get('/quen-mat-khau/otp', [PasswordController::class, 'forgotPasswordChangeGet']);
    Route::post('/quen-mat-khau/otp', [PasswordController::class, 'forgotPasswordChangePost']);
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [HomeController::class, 'home'])->name("home");
        Route::group(['prefix' => 'shop-xu-war'], function () {
            Route::get('/', [WarController::class, 'getShop'])->name("shop-war");
            Route::post('/', [WarController::class, 'postShop']);
            Route::get('/knb', [WarController::class, 'getWarKnb'])->name("warsKnb");
            Route::post('/knb', [WarController::class, 'postWarKnb']);
            Route::get('/lich-su-mua', [WarController::class, 'warHistory'])->name("warHistory");
        });
        Route::group(['prefix' => 'packs'], function () {
            Route::get('/', [PackController::class, 'get'])->name("packs");
            Route::get('/{id}/buy', [PackController::class, 'buy']);
        });
        Route::get('/set_main_char/{id}', [AuthController::class, 'setMainChar']);

        Route::group(['prefix' => 'doi-mon-phai'], function () {
            Route::get('/', [AuthController::class, 'changeClassGet'])->name("changeClass");
            Route::post('/', [AuthController::class, 'changeClassPost']);
        });

        Route::get('/logout', function () {
            Auth::logout();
            return redirect("/dang-nhap");
        });

        Route::group(['prefix' => 'knb'], function () {
            Route::get('/', [KnbController::class, 'getKnb'])->name("knb");
            Route::post('/', [KnbController::class, 'postKnb']);
        });

        Route::get('/msg', [HomeController::class, 'getMsg'])->name("msg");
        Route::post('/msg', [HomeController::class, 'postMsg']);
        Route::get('/pk', [HomeController::class, 'pk'])->name("pk");
        Route::get('/wars', [HomeController::class, 'wars'])->name("wars");

        Route::post('/inventory', [AuthController::class, 'getItem']);


        Route::get('/shop-xu-web', [AchievementController::class, 'shop'])->name("shop-coin");
        Route::post('/shop-xu-web', [AchievementController::class, 'postShop']);

        Route::get('/nap-tien', [DepositController::class, 'getNapTien'])->name("payment");

        Route::get('/ruong-may-man', [ShakeController::class, 'shake'])->name("shake");
        Route::post('/ruong-may-man', [ShakeController::class, 'postWheelItem']);
        Route::post('/ruong-may-man/mua-luot', [ShakeController::class, 'addLuot']);

        // Route::get('/tam-bao', [ShakeController::class, 'shake'])->name("tambao");
        // Route::post('/tam-bao', [ShakeController::class, 'postWheelItem']);
        // Route::post('/tam-bao/mua-luot', [ShakeController::class, 'addLuot']);

        Route::group(['prefix' => 'shops'], function () {
            Route::get('/', [ShopController::class, 'getShop'])->name("shops");
            Route::post('/', [ShopController::class, 'postShop']);
        });

        Route::get('/vip', [VipController::class, 'vip'])->name("vip");
        Route::get('/vip/{id}/using', [VipController::class, 'postVip']);

        Route::group(['prefix' => 'giftcodes'], function () {
            Route::get('/', [GiftcodeController::class, 'getGiftCode'])->name("giftcodes");
            Route::get('/{id}/using', [GiftcodeController::class, 'useGiftCode']);
        });

        Route::post('/otp', [PasswordController::class, 'sendOtp']);

        Route::group(['prefix' => '/doi-mat-khau'], function () {
            Route::get('/', [PasswordController::class, 'getChangePassword'])->name("password");
            Route::post('/', [PasswordController::class, 'postChangePassword']);
        });

        Route::group(['prefix' => '/doi-email'], function () {
            Route::post('/otp', [ChangeEmailController::class, 'sendOtp']);
            Route::get('/', [ChangeEmailController::class, 'getChange']);
            Route::post('/', [ChangeEmailController::class, 'postChange']);
        });


        Route::get('/chars', [AuthController::class, 'chars'])->name("chars");

        Route::group(['prefix' => 'dich-vu'], function () {
            Route::get('/', [ServiceController::class, 'index'])->name('services');
            Route::get('/gia-han-vip', [ServiceController::class, 'addVip']);
            Route::get('/cap-nhat-vip', [ServiceController::class, 'updateVip']);
        });


        Route::controller(LoggingController::class)->group(function () {
            Route::get('/refines', 'refines')->name("refines");
            Route::get('/logins', 'logins')->name("logins");
            Route::get('/boss', 'boss')->name("boss");
        });

    });
});
