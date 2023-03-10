<x-wireforms::fields
		:name="$name"
		:id="$id"
		:required="$required"
		:label="$label"
		:show-label="$showLabel"
		:help="$help"
		:key="$key"
		{{ $attributes->whereDoesntStartWith(['data', 'x-', 'wire:model', 'wire:change']) }}
>
	<div class="flex items-center"
			{{ $attributes->whereStartsWith(['x-']) }}
	>
        <livewire:sashalenz.nova-poshta-wireforms-fields.livewire.nova-poshta-street-select
				:name="$id"
				:required="$required"
				:placeholder="$placeholder"
				:readonly="$readonly"
				:searchable="$searchable"
				:nullable="$nullable"
				:value="$value"
				:key="$key ?? $id"
				:city-ref="$cityRef"
				:title-key="$titleKey"
				:title-value="$titleValue"
		/>
	</div>
</x-wireforms::fields>
