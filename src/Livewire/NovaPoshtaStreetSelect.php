<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Livewire;

use Illuminate\Support\Collection;
use Sashalenz\NovaPoshtaApi\ApiModels\Address;
use Sashalenz\NovaPoshtaApi\DataTransferObjects\Address\StreetData;
use Sashalenz\NovaPoshtaApi\Exceptions\NovaPoshtaException;

final class NovaPoshtaStreetSelect extends NovaPoshtaBaseSelect
{
    public string $cityRef;

    protected $listeners = [
        'updatedCityRef',
    ];

    public function mount(
        string $name,
        string $placeholder = null,
        string $value = null,
        bool $required = false,
        bool $readonly = false,
        ?int $minInputLength = null,
        ?int $limit = 20,
        bool $searchable = true,
        ?string $viewName = null,
        ?string $titleKey = null,
        ?string $titleValue = null,
        ?array $emitTo = [],
        ?string $cityRef = null,
    ): void {
        $this->name = $name;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->readonly = $readonly;
        $this->minInputLength = $minInputLength;
        $this->limit = $limit;
        $this->searchable = $searchable;
        $this->viewName = $viewName;
        $this->titleKey = $titleKey;
        $this->titleValue = $titleValue;
        $this->emitTo = $emitTo;
        $this->cityRef = $cityRef;
    }

    public function updatedCityRef(string $value): void
    {
        $this->cityRef = $value;
        $this->setSelected(null);
        $this->readonly = is_null($value);
    }

    public function getResultsProperty(): Collection
    {
        if (! $this->isOpen) {
            return collect();
        }

        try {
            return $this->address
                ->setCityRef($this->cityRef)
                ->when(
                    $this->searchable && $this->showResults(),
                    fn (Address $address) => $address->setFindByString($this->search)
                )
                ->getStreet()
                ->mapWithKeys(fn (StreetData $row) => [
                    $row->ref => $row->description,
                ]);
        } catch (NovaPoshtaException) {
            return collect();
        }
    }
}
