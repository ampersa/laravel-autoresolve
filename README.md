# Laravel (Artisan) Autoresolver
Automatically resolve Laravel (Artisan) commands from without the need to explicitly specify in app/Console/Kernel.php

## Installation
Install via composer:
```bash
$ composer require ampersa\laravel-autoresolve
```

Include the service provider in app/config.php

```php
'providers' => [
    ...
    Ampersa\LaravelAutoresolve\LaravelAutoresolveServiceProvider::class,
    ...
];
```

Publish the configuration

```bash
$ php artisan vendor:publish --provider="Ampersa\LaravelAutoresolve\LaravelAutoresolveServiceProvider"
```

## Contributing
1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request
