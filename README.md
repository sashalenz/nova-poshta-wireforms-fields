# This is my package nova-poshta-wireforms-fields

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sashalenz/nova-poshta-wireforms-fields.svg?style=flat-square)](https://packagist.org/packages/sashalenz/nova-poshta-wireforms-fields)
[![Total Downloads](https://img.shields.io/packagist/dt/sashalenz/nova-poshta-wireforms-fields.svg?style=flat-square)](https://packagist.org/packages/sashalenz/nova-poshta-wireforms-fields)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require sashalenz/nova-poshta-wireforms-fields
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="nova-poshta-wireforms-fields-views"
```

## Usage

```php
use Illuminate\Support\Collection;
use Sashalenz\NovaPoshtaWireformsFields\FormFields\NovaPoshtaWarehouseField;
use Xite\Wireforms\FormFields\HiddenField;

public function fields(): Collection
{
    return collect([
        NovaPoshtaWarehouseField::make('warehouse_ref', __('Warehouse Ref'))
            ->required()
            ->searchable()
            ->cityRef('CITY REF HERE')
            ->titleKey('warehouse_name')
            ->rules([
                'uuid'
            ]),
            
        HiddenField::make('warehouse_name', __('Warehouse Name'))
            ->nullable()
            ->rules([
                'string'
            ])
    ]);
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Oleksandr Petrovskyi](https://github.com/sashalenz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
