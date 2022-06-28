# Auditoria

Lunia Consultores S.L.

## Installation

Install the package via composer:

```bash
composer require lunia/auditoria
```

Publish configuration and service provider:

```bash
php artisan vendor:publish --provider="Lunia\Auditoria\Providers\AuditoriaApplicationServiceProvider"
```

Configure other DB connection in _config/database.php_ and then set in _.env_:

```env
AUDITORIA_DB_CONNECTION=$DB_CONNECTION_NAME
AUDITORIA_ENABLE=true
```

Register published **AuditoriaServiceProvider** in _config/app.php_:
```php
return [
    ...
    
    \App\Providers\AuditoriaServiceProvider::class,
    
    ...
]
```

Set variable in _phpunit.xml_ to not audit while running tests:
```xml
<server name="AUDITORIA_ENABLE" value="false" force="true"/>
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email desarrollo@lunia.es instead of using the issue tracker.

## Credits

-   [Lunia Consultores S.L](https://github.com/lunia)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
