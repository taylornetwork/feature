# Feature for Laravel

A package that provides a facade to easily access logic to determine if a feature is usable.

## Install

Via Composer

``` bash
$ composer require taylornetwork/feature
```

## Setup

### Register Service Provider 

Add the service provider to the providers array in `config/app.php`

``` php
'providers' => [

	TaylorNetwork\Feature\FeatureServiceProvider::class,

],
```

### Register Facade

Add the facade to the aliases array in `config/app.php`

``` php
'aliases' => [

	'Feature' => TaylorNetwork\Feature\Facades\Feature::class,

],
```

### Publish Config

Publish `feature.php` to your `config` directory

``` bash
$ php artisan vendor:publish
```

## Usage

### Make a Feature Class

This package comes with a `make:feature` artisan command to generate feature classes in the namespace set in `config/feature.php`, `App\Features` by default.

For example, we want to use [SweetAlert2][link-swal], but the features don't work on some devices, we would want to create a `SweetAlert` feature class.

``` bash
$ php artisan make:feature SweetAlert
```

Would generate `app/Features/SweetAlert.php`

``` php
namespace App\Features;

use TaylorNetwork\Feature\BaseFeature;

class SweetAlert extends BaseFeature
{

}

```

You can add all logic regarding SweetAlert in this class.

---

Optionally the `make:feature` command accepts an `--alias` option which will add an alias to call the class with. 

For example to add an alias `swal`, for the `SweetAlert` class.

``` bash
$ php artisan make:feature SweetAlert --alias=swal
```

The same file is generated as above, but it now includes a static property `$alias`

```php
namespace App\Features;

use TaylorNetwork\Feature\BaseFeature;

class SweetAlert extends BaseFeature
{
	public static $alias = 'swal';
}
```

#### Accessing Other Feature Classes within a Feature Class

All feature classes should extend the `TaylorNetwork\Feature\BaseFeature` class, which gives easy access to other feature classes.

The `BaseFeature` class has a `getFeatureInstance()` method that returns the original instance of the Feature class that called this feature class.

This can be useful to access any instantiated packages (see [Packages](#packages) for more details), or other feature classes.

For example in our `SweetAlert` class we want to access another feature class, `Toastr`, if SweetAlert doesn't work on this device and display a message. 

``` php
namespace App\Features;

use TaylorNetwork\Feature\BaseFeature;

class SweetAlert extends BaseFeature
{
	public function displayError()
	{
		$msg = 'SweetAlert not supported.';
		$this->getFeatureInstance()->Toastr()->errorMessage($msg);
	}
}
```

### Feature Facade

#### Accessing Feature Classes 

All feature classes are accesible via the `Feature` facade. 

To access any feature class, call the facade and the class name or alias as a function.

``` php
Feature::ClassName()

// OR

Feature::ClassAlias()
```

For example to access our newly created `SweetAlert` class. We could call

``` php
Feature::SweetAlert()

// OR

Feature::swal()
```

#### Available Methods

The `Feature` class methods are accessible using the facade statically. 

``` php
Feature::method()
```

##### getPackages ()

Returns an array of the packages and their instances registered with `TaylorNetwork\Feature`

See [Packages](#packages) for more details on packages.

##### getPackage (string $name)

Returns an instance of a package. Same as calling `Feature::getPackages()[$name]`.

See [Packages](#packages) for more details on packages.

##### getClasses ()

Returns an array of all accessible feature classes.

Using our SweetAlert example with the `swal` alias.

`Feature::getClasses()`

Returns

``` php
[
	'SweetAlert' => App\Features\SweetAlert {#xxx},
	'swal' => App\Features\SweetAlert {#xxx},
]
```

##### getClass (string $name)

Returns an instance of a feature class. 

For example, instead of calling `Feature::SweetAlert()`, using this method you could call `Feature::getClass('SweetAlert')`

## Packages

`TaylorNetwork\Feature` allows you to add packages that can be instantiated and accessed using the `getPackage($name)` or `getPackages()[$name]` methods (see [Available Methods](#available-methods)).

Packages must be included in `config/feature.php` and are accessible by their array key name.

For example, to include the [taylornetwork/name-formatter][link-tn-name-format], add to the `packages` array in `config/feature.php`

``` php
'packages' => [
	'nameFormatter' => \TaylorNetwork\Formatters\Name\Formatter::class,
],
```  
*Note: The entire fully qualified name needs to be the array value for the package to instantiated properly.*

Once packages are registered they can be accessed by the `Feature` facade, or from inside a feature class using the `getPackage` method.

### Feature Facade

To access the `nameFormatter` from the feature facade

``` php
Feature::getPackage('nameFormatter')
```

Returns an instance of `TaylorNetwork\Formatters\Name\Formatter`

### Feature Classes

To access the `nameFormatter` from a feature class

``` php
class ExampleFeatureClass extends BaseFeature
{
	public function formatName($name)
	{
		return $this->getFeatureInstance()->getPackage('nameFormatter')->format($name);
	}
}
```

## Credits

- [Sam Taylor][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-swal]: https://limonte.github.io/sweetalert2
[link-tn-name-format]: https://github.com/taylornetwork/name-formatter
[link-author]: https://github.com/taylornetwork