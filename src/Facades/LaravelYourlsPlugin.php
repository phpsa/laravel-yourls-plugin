<?php

namespace Phpsa\LaravelYourlsPlugin\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelYourlsPlugin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Phpsa\LaravelYourlsPlugin\LaravelYourlsPlugin::class;
    }
}
