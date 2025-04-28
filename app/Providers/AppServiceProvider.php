<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Force HTTPS only in production
        if (App::environment('production')) {
            URL::forceScheme('https');

            // SET path upload khusus production
            // Config::set('app.upload_base_path', '/home/username/public_html');
            Config::set('app.upload_base_path', '/home/miihyaud/public_html');
        }

        if (App::environment('local')) {
            // SET path upload untuk local
            Config::set('app.upload_base_path', public_path());
        }
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
