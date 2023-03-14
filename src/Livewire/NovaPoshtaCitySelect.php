<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Livewire;

use Illuminate\Support\Collection;
use Sashalenz\NovaPoshtaApi\ApiModels\Address;
use Sashalenz\NovaPoshtaApi\Exceptions\NovaPoshtaException;

final class NovaPoshtaCitySelect extends NovaPoshtaBaseSelect
{
    public ?int $minInputLength = 1;

    public function getResultsProperty(): ?Collection
    {
        if (! $this->isOpen) {
            return collect();
        }

        try {
            return Address\Address::make()
                ->getCities(
                    Address\RequestData\GetCitiesRequest::from([
                        'limit' => $this->limit,
                        'findByString' => $this->search
                    ])
                )
                ->toCollection()
                ->mapWithKeys(fn (Address\ResponseData\CityData $row) => [
                    $row->ref => $row->description,
                ]);
        } catch (NovaPoshtaException) {
            return collect();
        }
    }
}
