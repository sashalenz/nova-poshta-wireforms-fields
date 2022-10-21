<?php

namespace Sashalenz\NovaPoshtaWireformsFields;

use Livewire\Livewire;
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

    public function packageBooted(): void
    {
        $this->loadViewComponentsAs('wireforms', [
            \Sashalenz\NovaPoshtaWireformsFields\Components\Fields\NovaPoshtaWarehouse::class,
        ]);

        Livewire::component(
            'nova-poshta-wireforms-fields.livewire.warehouse-search',
            \Sashalenz\NovaPoshtaWireformsFields\Livewire\WarehouseSearch::class
        );
    }
}
