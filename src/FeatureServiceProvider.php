<?php

namespace TaylorNetwork\Feature;

use Illuminate\Support\ServiceProvider;
use TaylorNetwork\Feature\Commands\FeatureMakeCommand;

class FeatureServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/feature.php' => config_path('feature.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/feature.php', 'feature');

        $this->commands([ FeatureMakeCommand::class ]);
        
        $this->app->bind('Feature', function(){
            return new Feature();
        });
    }
}
