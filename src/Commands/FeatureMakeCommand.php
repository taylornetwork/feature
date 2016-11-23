<?php

namespace TaylorNetwork\Feature\Commands;

use Illuminate\Console\GeneratorCommand;

class FeatureMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:feature {name} {--alias=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new feature class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Feature Class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/feature.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . config('feature.namespace', 'Features');
    }

    /**
     * @inheritdoc
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $alias = $this->option('alias');
        return $this->replaceNamespace($stub, $name)->replaceAlias($stub, $alias)->replaceClass($stub, $name);
    }

    /**
     * Replace key in stub
     * 
     * @param $stub
     * @param $alias
     * @return $this
     */
    protected function replaceAlias(&$stub, $alias)
    {
        if($alias == 'default')
        {
            $stub = str_replace('ALIAS', '', $stub);
        }
        else
        {
            $stub = str_replace('ALIAS', 'public static $alias = \''.$alias.'\';', $stub);    
        }
        
        return $this;
    }
}