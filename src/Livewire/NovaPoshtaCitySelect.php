<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Sashalenz\NovaPoshtaApi\ApiModels\Address;
use Sashalenz\NovaPoshtaApi\DataTransferObjects\Address\CityData;
use Sashalenz\NovaPoshtaApi\Exceptions\NovaPoshtaException;
use Sashalenz\Wireforms\Livewire\ModelSelect;

final class NovaPoshtaCitySelect extends ModelSelect
{
    public ?string $titleKey = null;
    public ?string $titleValue = null;
    public int $limit = 50;
    public ?int $minInputLength = 1;
    public array $emitTo = [];

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
        ?string $titleKey = null,
        ?string $titleValue = null,
        ?array $emitTo = []
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
        $this->titleKey = $titleKey;
        $this->titleValue = $titleValue;
        $this->emitTo = $emitTo;
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

        foreach ($this->emitTo as $emitTo) {
            $this->emitTo($emitTo, 'updatedCityRef', $this->value);
        }

        $this->isOpen = false;
        $this->search = '';
    }

    public function showResults(): bool
    {
        return $this->searchable && ($this->minInputLength < Str::length($this->search));
    }

    public function getSelectedValueProperty():? string
    {
        return $this->value;
    }

    public function getSelectedTitleProperty():? string
    {
        return $this->titleValue;
    }

    public function getAddressProperty(Address $address): Address
    {
        return $address;
    }

    public function getResultsProperty():? Collection
    {
        if (!$this->isOpen) {
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

    public function isCurrent(string $key): bool
    {
        return !is_null($this->selectedValue) && $key === $this->selectedValue;
    }
}
