<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangeEmailController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GiftcodeController;
use App\Http\Controllers\GuildController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KnbController;
use App\Http\Controllers\LoggingController;
use App\Http\Controllers\OfflineController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\WarController;
use App\Http\Controllers\IngameController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShakeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VipController;
use App\Http\Controllers\WheelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackController;

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

Route::get('/dang-ky', [AuthController::class, 'signup']);
Route::post('/dang-ky', [AuthController::class, 'signupPost']);
Route::get('/reload-captcha', [AuthController::class, 'reloadCaptcha']);

Route::get('/dang-ky-nhanh', [AuthController::class, 'fastSignup']);
Route::post('/dang-ky-nhanh', [AuthController::class, 'fastSignupPost']);

Route::post('/dang-nhap', [AuthController::class, 'signinPost']);
Route::get('/dang-nhap', [AuthController::class, 'signin'])->name("login");

Route::get('/quen-mat-khau', [PasswordController::class, 'forgotPasswordGet']);
Route::post('/quen-mat-khau', [PasswordController::class, 'forgotPasswordPost']);
Route::get('/auto', [HomeController::class, 'auto'])->name("auto");
Route::get('/quen-mat-khau/otp', [PasswordController::class, 'forgotPasswordChangeGet']);
Route::post('/quen-mat-khau/otp', [PasswordController::class, 'forgotPasswordChangePost']);
Route::get('/tai-game', [HomeController::class, 'download'])->name("download");
Route::get('/huong-dan', [HomeController::class, 'help'])->name("help");
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'home'])->name("home");
    // Route::group(['prefix' => 'wars'], function () {
    //     Route::get('/', [WarController::class, 'getShop'])->name("wars");
    //     Route::post('/', [WarController::class, 'postShop']);
    //     Route::get('/knb', [WarController::class, 'getWarKnb'])->name("warsKnb");
    //     Route::post('/knb', [WarController::class, 'postWarKnb']);
    //     Route::get('/lich-su-mua', [WarController::class, 'warHistory'])->name("warHistory");
    // });
    // Route::group(['prefix' => 'packs'], function () {
    //     Route::get('/', [PackController::class, 'get'])->name("packs");
    //     Route::get('/{id}/buy', [PackController::class, 'buy']);
    // });
    // Route::group(['prefix' => 'meta'], function () {
    //     Route::get('/', [MetaController::class, 'create'])->name("meta");
    //     Route::get('/users', [MetaController::class, 'users']);
    //     Route::get('/login/{id}', [MetaController::class, 'login']);
    //     Route::post('/', [MetaController::class, 'store']);
    //     Route::get('/{id}/delete', [MetaController::class, 'delete']);
    // });
    //Route::get('/event', [AuthController::class, 'event'])->name("event");
    //Route::post('/event', [AuthController::class, 'postEvent']);
    Route::get('/set_main_char/{id}', [AuthController::class, 'setMainChar']);

    //Route::get('/ca-nhan', [AuthController::class, 'profile'])->name("profile");

    Route::get('/bang-xep-hang', [RankController::class, 'rank'])->name("rank");
    //Route::get('/18-mon-phai', [HomeController::class, 'class18'])->name("18class");

    Route::group(['prefix' => 'doi-mon-phai'], function () {
        Route::get('/', [AuthController::class, 'changeClassGet'])->name("changeClass");
        Route::post('/', [AuthController::class, 'changeClassPost']);
    });

    Route::group(['prefix' => 'ingame'], function () {
        Route::get('/', [IngameController::class, 'index'])->name("ingame");
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
    Route::get('/pk', [HomeController::class, 'pk']);

    // Route::group(['prefix' => 'nhan-vat'], function () {
    //     Route::get('/', [AuthController::class, 'nhanVat'])->name("chars");
    //     Route::get('/{id}', [AuthController::class, 'search'])->name("charSearch");
    // });

    Route::group(['prefix' => 'thanh-tuu'], function () {
        Route::get('/', [AchievementController::class, 'get'])->name("rewards");
        Route::get('/{type}/{id}', [AchievementController::class, 'post']);
    });

    // Route::get('/inventory', [AuthController::class, 'inventory'])->name("inventory");
    Route::post('/inventory', [AuthController::class, 'getItem']);

    // Route::get('/bang-chien', [WarController::class, 'index'])->name("war");
    // Route::get('/war-live', [WarController::class, 'live'])->name("war-live");

    Route::get('/shop-xu-web', [AchievementController::class, 'shop'])->name("shop-coin");
    Route::post('/shop-xu-web', [AchievementController::class, 'postShop']);

    Route::group(['prefix' => 'nhiem-vu'], function () {
        Route::get('/', [QuestController::class, 'get'])->name("quests");
        Route::get('/{id}/using', [QuestController::class, 'post']);
    });

    //Route::get('/bang-xep-hang', [RankController::class, 'rank'])->name("rank");
    Route::get('/nap-tien', [DepositController::class, 'getNapTien'])->name("payment");
    //Route::get('/lich-su-nap-tien', [DepositController::class, 'histories'])->name("histories");

    Route::get('/ruong-may-man', [ShakeController::class, 'shake'])->name("shake");
    Route::post('/ruong-may-man', [ShakeController::class, 'postWheelItem']);
    Route::post('/ruong-may-man/mua-luot', [ShakeController::class, 'addLuot']);


    // Route::get('/tam-bao', [ShakeController::class, 'shake'])->name("tambao");
    // Route::post('/tam-bao', [ShakeController::class, 'postWheelItem']);
    // Route::post('/tam-bao/mua-luot', [ShakeController::class, 'addLuot']);

    Route::group(['prefix' => 'shops'], function () {
        Route::get('/', [ShopController::class, 'getShop'])->name("shops");
        Route::post('/', [ShopController::class, 'postShop']);
        //Route::get('/lich-su-mua', [ShopController::class, 'shopHistory'])->name("shopHistory");
    });

    // Route::group(['prefix' => 'mini-game'], function () {
    //     Route::get('/', [GameController::class, 'index'])->name("game");
    //     Route::post('/', [GameController::class, 'post']);
    //     Route::get('/lich-su-mua', [ShopController::class, 'shopHistory'])->name("shopHistory");
    // });

    Route::group(['prefix' => 'giftcodes'], function () {
        Route::get('/', [GiftcodeController::class, 'getGiftCode'])->name("giftcodes");
        Route::get('/{id}/using', [GiftcodeController::class, 'useGiftCode']);
    });

    Route::get('/transactions', [TransactionController::class, 'transactions'])->name("transactions");

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

    Route::get('/online', [HomeController::class, 'online'])->name("online");
    // Route::group(['prefix' => '/bang-hoi'], function () {
    //     Route::get('/', [GuildController::class, 'getGuild'])->name("guild");
    //     Route::post('/', [GuildController::class, 'postGuild']);
    // });

    Route::get('/chars', [AuthController::class, 'chars'])->name("chars");

    Route::get('/items', [ItemController::class, 'items'])->name("items");

    //Route::post('/post-wheel/{id}', [WheelController::class, 'postWheelItem']);

    // Route::group(['prefix' => 'vong-quay-may-man'], function () {
    //     Route::get('/', [WheelController::class, 'index'])->name('spin');
    //     Route::get('/{id}', [WheelController::class, 'show']);
    // });

    // Route::group(['prefix' => 'offline'], function () {
    //     Route::get('/', [OfflineController::class, 'index'])->name('offline');
    //     Route::post('/', [OfflineController::class, 'post']);
    //     Route::get('/{id}', [OfflineController::class, 'show']);
    // });

    Route::group(['prefix' => 'dich-vu'], function () {
        Route::get('/', [ServiceController::class, 'index'])->name('services');
        Route::get('/gia-han-vip', [ServiceController::class, 'addVip']);
        Route::get('/cap-nhat-vip', [ServiceController::class, 'updateVip']);
    });

    Route::get('/chats', [ChatController::class, 'chats']);
    // Route::get('/tro-chuyen', [ChatController::class, 'chatsxx'])->name('chat');
    // Route::post('/tro-chuyen', [ChatController::class, 'message']);
    //Route::get('/vip-chat', [ChatController::class, 'vipChat']);

    Route::controller(LoggingController::class)->group(function () {
        Route::get('/refines', 'refines')->name("refines");
        Route::get('/logins', 'logins')->name("logins");
        Route::get('/boss', 'boss')->name("boss");
    });

    // Route::group(['prefix' => 'mua-goi-vip'], function () {
    //     Route::get('/', [VipController::class, 'index'])->name("shops");
    //     Route::post('/', [VipController::class, 'store']);
    //     Route::get('/lich-su', [VipController::class, 'history'])->name("history");
    // });

    //Route::get('/dau-tu/{id}/lich-su', [TransactionController::class, 'vipHistory']);

});
