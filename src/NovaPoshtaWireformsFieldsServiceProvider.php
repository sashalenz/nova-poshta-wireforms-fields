<?php

namespace Sashalenz\NovaPoshtaWireformsFields;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NovaPoshtaWireformsFieldsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('nova-poshta-wireforms-fields')
            ->hasViews();
    }
}
