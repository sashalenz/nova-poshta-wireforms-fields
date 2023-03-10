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
            \Sashalenz\NovaPoshtaWireformsFields\Components\Fields\NovaPoshtaCity::class,
            \Sashalenz\NovaPoshtaWireformsFields\Components\Fields\NovaPoshtaWarehouse::class,
            \Sashalenz\NovaPoshtaWireformsFields\Components\Fields\NovaPoshtaStreet::class,
        ]);

        Livewire::component(
            'sashalenz.nova-poshta-wireforms-fields.livewire.nova-poshta-city-select',
            \Sashalenz\NovaPoshtaWireformsFields\Livewire\NovaPoshtaCitySelect::class
        );

        Livewire::component(
            'sashalenz.nova-poshta-wireforms-fields.livewire.nova-poshta-warehouse-select',
            \Sashalenz\NovaPoshtaWireformsFields\Livewire\NovaPoshtaWarehouseSelect::class
        );

        Livewire::component(
            'sashalenz.nova-poshta-wireforms-fields.livewire.nova-poshta-street-select',
            \Sashalenz\NovaPoshtaWireformsFields\Livewire\NovaPoshtaStreetSelect::class
        );
    }
}
