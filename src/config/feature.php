<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Local Namespace
     |--------------------------------------------------------------------------
     | 
     | The namespace that all your features are and will be stored.
     | App\ is prepended.
     |
     */
    'namespace' => 'Features',

    /*
     |--------------------------------------------------------------------------
     | Classes to Exclude
     |--------------------------------------------------------------------------
     | 
     | If there are any classes in the above namespace you do not want to use
     | with TaylorNetwork\Feature, add the name of the class into this array.
     |
     */
    'exclude' => [],

    /*
     |--------------------------------------------------------------------------
     | Packages for Features
     |--------------------------------------------------------------------------
     | 
     | If there are any other packages you want to use with 
     | TaylorNetwork\Feature, add them here. 
     | 
     | This is useful if you have a few 
     | different feature classes and don't want to instantiate the same package
     | multiple times. 
     |
     | The Feature class will instantiate each of these 
     | packages and they will be accessible from every feature class that 
     | extends the BaseFeature class by $this->getFeatureInstance()->packageKey().
     |
     | For example: 
     |      I want to add the taylornetwork\name-formatter package to this array,
     |      I would install it via composer, then add the FULL class name to 
     |      the array with the array key being what I want to access the class by, 
     |      'nameFormatter' for example.
     |
     |      'packages' => [
     |          'nameFormatter' => \TaylorNetwork\Formatters\Name\Formatter::class,
     |      ],
     |
     |      Now from all my feature classes in App\Features, whenever I need
     |      the taylornetwork\name-formatter package I can call: 
     |      $this->getFeatureInstance()->nameFormatter()
     |      And chain any of the methods from taylornetwork\name-formatter on to that.
     | 
     */
    'packages' => [],
    
];