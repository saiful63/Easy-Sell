<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helper\DeleteImg;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('DeleteImg',function($app){
            return new DeleteImg();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
