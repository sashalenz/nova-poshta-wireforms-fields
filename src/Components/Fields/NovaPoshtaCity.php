<?php

namespace Sashalenz\NovaPoshtaWireformsFields\Components\Fields;

use Illuminate\Contracts\View\View;
use Xite\Wireforms\Components\Fields\Field;

class NovaPoshtaCity extends Field
{
    public function __construct(
        string $name,
        $value,
        bool $required = false,
        bool $disabled = false,
        bool $readonly = false,
        bool $showLabel = true,
        ?string $label = null,
        ?string $key = null,
        ?string $placeholder = null,
        ?string $help = null,
        public bool $nullable = false,
        public bool $searchable = false,
        public ?array $emitTo = [],
        public ?string $titleKey = null,
        public ?string $titleValue = null
    ) {
        parent::__construct(
            $name,
            $value,
            $required,
            $disabled,
            $readonly,
            $showLabel,
            $label,
            $key,
            $placeholder,
            $help
        );
    }

    public function render(): View
    {
        return view('nova-poshta-wireforms-fields::fields.nova-poshta-city')
            ->with($this->data());
    }
}
