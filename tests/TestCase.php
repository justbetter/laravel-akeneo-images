<?php

namespace JustBetter\AkeneoImages\Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use JustBetter\AkeneoClient\ServiceProvider as AkeneoClientServiceProvider;
use JustBetter\AkeneoImages\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            AkeneoClientServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
