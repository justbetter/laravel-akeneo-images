<?php

namespace JustBetter\AkeneoImages;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustBetter\AkeneoImages\Actions\ProcessImage;
use JustBetter\AkeneoImages\Actions\UploadImage;
use JustBetter\AkeneoImages\Commands\ProcessImageCommand;
use JustBetter\AkeneoImages\Commands\UploadImageCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this
            ->registerConfig()
            ->registerActions();
    }

    protected function registerConfig(): static
    {
        $this->mergeConfigFrom(__DIR__.'/../config/akeneo-images.php', 'akeneo-images');

        return $this;
    }

    protected function registerActions(): static
    {
        ProcessImage::bind();
        UploadImage::bind();

        return $this;
    }

    public function boot(): void
    {
        $this
            ->bootConfig()
            ->bootCommands()
            ->bootMigrations();
    }

    protected function bootConfig(): static
    {
        $this->publishes([
            __DIR__.'/../config/akeneo-images.php' => config_path('akeneo-images.php'),
        ], 'config');

        return $this;
    }

    protected function bootCommands(): static
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ProcessImageCommand::class,
                UploadImageCommand::class,
            ]);
        }

        return $this;
    }

    protected function bootMigrations(): static
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        return $this;
    }
}
