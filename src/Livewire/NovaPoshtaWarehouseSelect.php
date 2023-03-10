<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Livewire;

use Illuminate\Support\Collection;
use Sashalenz\NovaPoshtaApi\ApiModels\Address;
use Sashalenz\NovaPoshtaApi\DataTransferObjects\Address\WarehouseData;
use Sashalenz\NovaPoshtaApi\Exceptions\NovaPoshtaException;

final class NovaPoshtaWarehouseSelect extends NovaPoshtaBaseSelect
{
    public string $cityRef;

    public bool $isPostomat = false;

    private const POSTOMAT_REF = 'f9316480-5f2d-425d-bc2c-ac7cd29decf0';

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
        bool $isPostomat = false
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
        $this->isPostomat = $isPostomat;
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
                    $this->isPostomat,
                    fn (Address $address) => $address->setTypeOfWarehouseRef(self::POSTOMAT_REF)
                )
                ->getWarehouses($this->search)
                ->take($this->limit)
                ->mapWithKeys(fn (WarehouseData $row) => [
                    $row->ref => $row->description,
                ]);
        } catch (NovaPoshtaException) {
            return collect();
        }
    }
}
