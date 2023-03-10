<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Livewire;

use Illuminate\Support\Collection;
use Sashalenz\NovaPoshtaApi\ApiModels\Address;
use Sashalenz\NovaPoshtaApi\DataTransferObjects\Address\CityData;
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
            return $this->address
                ->setLimit($this->limit)
                ->when($this->search, fn (Address $req) => $req->setFindByString($this->search))
                ->getCities()
                ->mapWithKeys(fn (CityData $row) => [
                    $row->ref => $row->description,
                ]);
        } catch (NovaPoshtaException) {
            return collect();
        }
    }
}
