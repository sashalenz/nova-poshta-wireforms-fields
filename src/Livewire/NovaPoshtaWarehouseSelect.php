<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Sashalenz\NovaPoshtaApi\ApiModels\Address;
use Sashalenz\NovaPoshtaApi\DataTransferObjects\Address\WarehouseData;
use Sashalenz\NovaPoshtaApi\Exceptions\NovaPoshtaException;
use Sashalenz\Wireforms\Livewire\ModelSelect;

final class NovaPoshtaWarehouseSelect extends ModelSelect
{
    public ?string $titleKey = null;

    public ?string $titleValue = null;

    public string $cityRef;

    public bool $isPostomat = false;

    private const POSTOMAT_REF = 'f9316480-5f2d-425d-bc2c-ac7cd29decf0';

    protected $listeners = [
        'updatedCityRef',
    ];

    public function mount(
        string $name,
        string $model,
        string $placeholder = null,
        string $createNewModel = null,
        string $createNewField = null,
        string $value = null,
        bool $required = false,
        bool $readonly = false,
        ?string $orderBy = null,
        ?string $orderDir = null,
        bool $searchable = true,
        ?string $cityRef = null,
        ?string $titleKey = null,
        ?string $titleValue = null,
        bool $isPostomat = false
    ): void {
        $this->name = $name;
        $this->model = $model;
        $this->placeholder = $placeholder;
        $this->createNewModel = $createNewModel;
        $this->createNewField = $createNewField;
        $this->value = $value;
        $this->required = $required;
        $this->readonly = $readonly;
        $this->orderBy = $orderBy;
        $this->orderDir = $orderDir;
        $this->searchable = $searchable;
        $this->cityRef = $cityRef;
        $this->titleKey = $titleKey;
        $this->titleValue = $titleValue;
        $this->isPostomat = $isPostomat;
    }

    public function updatedCityRef(string $value): void
    {
        $this->cityRef = $value;
        $this->setSelected(null);
    }

    public function setSelected($value): void
    {
        if ($this->value === $value) {
            $this->isOpen = false;

            return;
        }

        $this->value = $value;
        $result = $this->results->get($value);
        $this->titleValue = $result;

        $this->emitUp('updatedChild', $this->name, $this->value);

        if ($this->titleKey) {
            $this->emitUp('updatedChild', $this->titleKey, $result);
        }

        $this->search = '';
        $this->isOpen = false;
    }

    public function showResults(): bool
    {
        return $this->searchable && (! is_int($this->minInputLength) || $this->minInputLength < Str::length($this->search));
    }

    public function getSelectedValueProperty(): ?string
    {
        return $this->value;
    }

    public function getSelectedTitleProperty(): ?string
    {
        return $this->titleValue;
    }

    public function getAddressProperty(Address $address): Address
    {
        return $address;
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

    public function isCurrent(string $key): bool
    {
        return ! is_null($this->selectedValue) && $key === $this->selectedValue;
    }
}
