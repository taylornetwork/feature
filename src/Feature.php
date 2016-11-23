<?php

namespace TaylorNetwork\Feature;

class Feature
{
    protected $instances;

    protected $classes;

    public function __construct()
    {
        foreach(config('feature.dependencies', []) as $accessAs => $dependency)
        {
            $this->initialize($this->instances[is_string($accessAs) ? $accessAs : $dependency], $dependency);
        }

        foreach(config('feature.classes', []) as $accessAs => $class)
        {
            $this->initialize($this->instances[is_string($accessAs) ? $accessAs : last(explode('\\', $class))], $class);
        }
    }

    protected function initialize($property, $class)
    {
        $this->$property = new $class;
        return $this;
    }

    public function getInstanceOf($name)
    {
        if(array_key_exists($name, $this->instances))
        {
            return $this->instances[$name];
        }
        return null;
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->classes))
        {
            return $this->classes[$name];
        }
        return null;
    }
}