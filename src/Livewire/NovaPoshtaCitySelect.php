<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Livewire;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Sashalenz\NovaPoshtaApi\ApiModels\Address;
use Sashalenz\NovaPoshtaApi\Exceptions\NovaPoshtaException;

final class NovaPoshtaCitySelect extends NovaPoshtaBaseSelect
{
    public ?int $minInputLength = 1;

    #[Computed]
    public function getResults(): ?Collection
    {
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
                    $row->ref => $row->settlementTypeDescription." ".$row->description,
                ]);
        } catch (NovaPoshtaException) {
            return collect();
        }
    }
}
