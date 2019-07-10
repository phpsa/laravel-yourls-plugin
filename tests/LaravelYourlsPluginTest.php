<?php

namespace Phpsa\LaravelYourlsPlugin\Tests;

use Orchestra\Testbench\TestCase;
use Phpsa\LaravelYourlsPlugin\ServiceProvider;
use Phpsa\LaravelYourlsPlugin\Facades\LaravelYourlsPlugin;

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
