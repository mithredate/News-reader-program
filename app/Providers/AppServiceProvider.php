<?php

namespace App\Providers;

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
        $this->app->when('App\Http\Controllers\Auth\AuthController')
            ->needs('Illuminate\Auth\Passwords\TokenRepositoryInterface')
            ->give(function($app){
            $name = $app['config']['auth.defaults.verify'];
            $config = $app['config']["auth.verify.{$name}"];
            $key = $app['config']['app.key'];

            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            $connection = isset($config['connection']) ? $config['connection'] : null;

            return new DatabaseTokenRepository(
                $app['db']->connection($connection),
                $config['table'],
                $key,
                $config['expire']
            );
        });
    }
}
