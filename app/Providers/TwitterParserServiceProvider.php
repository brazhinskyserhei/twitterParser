<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TwitterParserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('twitterParse','App\Services\ParseTwitter');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
