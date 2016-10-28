<?php

namespace TaylorNetwork\Feature;

use Illuminate\Support\ServiceProvider;
use App;

class FeatureServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('Feature', function(){
            return new Feature;
        });
    }
}
