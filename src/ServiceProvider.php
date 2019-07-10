<?php

namespace Phpsa\LaravelYourlsPlugin;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    protected $defer = true;

    const CONFIG_PATH = __DIR__.'/../config/laravel-yourls-plugin.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('laravel-yourls-plugin.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'laravel-yourls-plugin'
        );

        $this->app->singleton(LaravelYourlsPlugin::class, function ($app) {
            return new LaravelYourlsPlugin($app['config']['laravel-yourls-plugin']);
        });
    }

    public function provides()
    {
        return [LaravelYourlsPlugin::class];
    }
}
