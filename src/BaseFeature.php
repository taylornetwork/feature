<?php

namespace TaylorNetwork\Feature;


abstract class BaseFeature
{
    /**
     * @var Feature
     */
    protected $feature;

    /**
     * Alias 
     * 
     * @var string
     */
    public static $alias;

    /**
     * BaseFeature constructor.
     * 
     * @param Feature $feature
     */
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }

    /**
     * Get the feature instance
     * 
     * @return Feature
     */
    public function getFeatureInstance()
    {
        return $this->feature;
    }
}