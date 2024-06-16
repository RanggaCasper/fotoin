<?php

namespace App\Providers;

use App\Models\WebsiteConf;
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
        $webConf = WebsiteConf::get();
        $this->app->instance('web_conf', $webConf);
    }
}
