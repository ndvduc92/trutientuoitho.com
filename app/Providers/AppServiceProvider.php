<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use hrace009\PerfectWorldAPI\API;

// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // DB::listen(function ($query) {
        //     Log::debug('SQL: ' . $query->sql . "------------".'Time: ' . $query->time . 'ms');
        // });
        $api = new API();
        view()->share('api', $api);
        Schema::defaultStringLength(191);
    }
}
