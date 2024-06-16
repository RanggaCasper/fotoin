<?php

namespace App\Providers;

use App\Models\WebsiteConf;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class WebConfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('website_conf')) {
            $webConf = WebsiteConf::get();
            $this->app->instance('web_conf', $webConf);
        }
    }
}
