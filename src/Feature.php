<?php

namespace TaylorNetwork\Feature;

use Illuminate\Console\AppNamespaceDetectorTrait;

class Feature
{
    use AppNamespaceDetectorTrait;

    /**
     * Array of packages instances
     * 
     * @var array
     */
    protected $packages;

    /**
     * Array of feature class instances
     * 
     * @var array
     */
    protected $classes;

    /**
     * Feature constructor.
     */
    public function __construct()
    {
        foreach (config('feature.packages', []) as $accessAs => $package)
        {
            $this->initialize('packages', is_string($accessAs) ? $accessAs : last(explode('\\', $package)), $package);
        }

        foreach (glob(app_path(str_replace('\\', '/', config('feature.namespace', 'Features')).'/*.php')) as $file)
        {
            $name = str_replace('.php', '', last(explode('/', $file)));
            $fullName = $this->getAppNamespace().config('feature.namespace', 'Features').'\\'.$name;

            if(!in_array($name, config('feature.exclude', [])))
            {
                $this->initialize('classes', $name, $fullName, $this);
                
                if($fullName::$alias)
                {
                    $this->initialize('classes', $fullName::$alias, $fullName, $this);
                }
            }
        }
    }

    /**
     * Get all package instances
     * 
     * @return array
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * Get a package instance
     * 
     * @param string $name
     * @return mixed|null
     */
    public function getPackage($name)
    {
        if(array_key_exists($name, $this->packages))
        {
            return $this->packages[$name];
        }
        return null;
    }

    /**
     * Get all class instances
     * 
     * @return array
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Get a class instance
     * 
     * @param string $name
     * @return mixed|null
     */
    public function getClass($name)
    {
        if(array_key_exists($name, $this->classes))
        {
            return $this->classes[$name];
        }
        return null;
    }
    

    /**
     * Instantiate a class in a property array
     * 
     * @param string $property
     * @param string $key
     * @param string $class
     * @return $this
     */
    protected function initialize($property, $key, $class, $argument = null)
    {
        if($argument)
        {
            $this->$property[$key] = new $class($argument);
        }
        else
        {
            $this->$property[$key] = new $class();
        }
        return $this;
    }

    /**
     * Call a feature class
     * 
     * @param string $class
     * @param array $arguments
     * @return mixed|null
     */
    public function __call($class, $arguments)
    {
        $this->getClass($class);
    }
}