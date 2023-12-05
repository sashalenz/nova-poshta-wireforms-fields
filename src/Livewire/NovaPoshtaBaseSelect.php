<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Livewire;

use Illuminate\Support\Str;
use Xite\Wireforms\Livewire\BaseSelect;

abstract class NovaPoshtaBaseSelect extends BaseSelect
{
    public ?string $titleKey = null;

    public ?string $titleValue = null;

    public array $emitTo = [];

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
        ?array $emitTo = []
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

        if ($viewName) {
            $this->viewName = $viewName;
        }
    }

    public function setSelected($value): void
    {
        if ($this->value === $value) {
            $this->isOpen = false;

            return;
        }

        $this->value = $value;

        $this->dispatch(
            event: $this->emitUp,
            key: $this->name,
            value: $this->value
        );

        if ($this->titleKey) {
            $result = $this->results->get($value);
            $this->titleValue = $result;

            $this->dispatch(
                event: $this->emitUp,
                key: $this->titleKey,
                value: $result
            );
        }

        foreach ($this->emitTo as $emitTo) {
            $this->dispatch(
                event: Str::of($this->name)->prepend('updated')->camel()->toString(),
                value: $this->value
            )->to($emitTo);
        }

        $this->search = '';
        $this->isOpen = false;
    }

    public function getSelectedValueProperty(): ?string
    {
        return $this->value;
    }

    public function getSelectedTitleProperty(): ?string
    {
        return $this->titleValue;
    }

    public function isCurrent(string $key): bool
    {
        return ! is_null($this->selectedValue) && $key === $this->selectedValue;
    }
}
