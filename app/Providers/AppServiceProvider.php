<?php

namespace App\Providers;

use App\Brokers\VerificationBrokerManager;
use App\Libraries\FileManager;
use App\Repositories\ArticlesRepository;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    

    /**
     * Bootstrap any application services.
     *
     * @param $app
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        

        $this->app->singleton('auth.verify',function ($app) {
            return new VerificationBrokerManager($app);
        });

        $this->app->singleton('FileManager', function($app){
            return new FileManager();
        });
    }
}
