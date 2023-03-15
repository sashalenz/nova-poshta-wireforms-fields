<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Livewire;

use Sashalenz\NovaPoshtaApi\ApiModels\Address;
use Illuminate\Support\Collection;
use Sashalenz\NovaPoshtaApi\Exceptions\NovaPoshtaException;

final class NovaPoshtaStreetSelect extends NovaPoshtaBaseSelect
{
    public string $cityRef;
    public ?int $minInputLength = 1;

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
        ?int $limit = 100,
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
        $this->titleKey = $titleKey;
        $this->titleValue = $titleValue;
        $this->emitTo = $emitTo;
        $this->cityRef = $cityRef;
        if ($viewName) {
            $this->viewName = $viewName;
        }
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
            return Address\Address::make()
                ->getStreet(
                    Address\RequestData\GetStreetRequest::from([
                        'cityRef' => $this->cityRef,
                        'findByString' => $this->searchable ? $this->search : ''
                    ])
                )
                ->toCollection()
                ->mapWithKeys(fn (Address\ResponseData\StreetData $row) => [
                    $row->ref => $row->streetsType." ".$row->description,
                ]);
        } catch (NovaPoshtaException) {
            return collect();
        }
    }
}
