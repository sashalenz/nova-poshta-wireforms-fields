<?php

namespace Sashalenz\NovaPoshtaWireformsFields\FormFields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sashalenz\NovaPoshtaWireformsFields\Components\Fields\NovaPoshtaWarehouse;
use Xite\Wireforms\Contracts\FieldContract;
use Xite\Wireforms\FormFields\FormField;

class NovaPoshtaWarehouseField extends FormField
{
    protected bool $nullable = false;

    protected bool $searchable = false;

    protected ?string $cityRef = null;

    protected ?string $titleKey = null;

    protected ?string $titleValue = null;

    public function cityRef(?string $cityRef): self
    {
        if (is_null($cityRef)) {
            $this->disabled = true;
            $this->cityRef = 'null';
        } else {
            $this->cityRef = $cityRef;
        }

        return $this;
    }

    public function titleKey(?string $titleKey): self
    {
        $this->titleKey = $titleKey;

        return $this;
    }

    public function nullable(): self
    {
        $this->nullable = true;
        $this->rules[] = 'nullable';

        return $this;
    }

    public function searchable(): self
    {
        $this->searchable = true;

        return $this;
    }

    public function renderField(?Model $model = null): Collection
    {
        if (! is_null($model)) {
            $this->value(
                $model->{$this->getName()}
            );

            if ($this->titleKey) {
                $this->titleValue = $model->{$this->titleKey};
            }
        }

        return collect([
            $this->render(),
        ]);
    }

    protected function render(): FieldContract
    {
        return NovaPoshtaWarehouse::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            nullable: $this->nullable,
            searchable: $this->searchable,
            label: $this->label,
            help: $this->help,
            placeholder: $this->placeholder,
            required: $this->required,
            readonly: $this->disabled,
            key: $this->key,
            cityRef: $this->cityRef,
            titleKey: $this->wireModel
                ? 'model.'.$this->titleKey
                : $this->titleKey,
            titleValue: $this->titleValue
        );
    }
}
