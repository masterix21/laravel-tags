<?php

namespace Masterix21\LaravelTags;

use Illuminate\Support\ServiceProvider;

class LaravelTagsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/tags.php' => config_path('tags.php'),
            ], 'config');

            if (! class_exists('CreateTagsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_tags_table.php.stub' => database_path(
                        'migrations/' . date('Y_m_d_His', time()) . '_create_tags_table.php'
                    )
                ], 'migrations');
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tags.php', 'tags');
    }
}
