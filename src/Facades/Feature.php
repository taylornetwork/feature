<?php

namespace TaylorNetwork\Feature\Facades;

use Illuminate\Support\Facades\Facade;

class Feature extends Facade
{
    /**
     * Get the facade accessor
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "Feature";
    }
}