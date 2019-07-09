<?php

namespace Phpsa\LaravelYourlsPlugin\Tests;

use Phpsa\LaravelYourlsPlugin\Facades\LaravelYourlsPlugin;
use Phpsa\LaravelYourlsPlugin\ServiceProvider;
use Orchestra\Testbench\TestCase;

class LaravelYourlsPluginTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'laravel-yourls-plugin' => LaravelYourlsPlugin::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
