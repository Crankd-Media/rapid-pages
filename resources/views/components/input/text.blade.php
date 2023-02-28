@props(['name' => '', 'label', 'value', 'type' => 'text', 'min' => null, 'max' => null, 'step' => null, 'prepend'])


@if ($label ?? null)
	{{-- @include('components.inputs.partials.label') --}}
	<label class="{{ $required ?? false ? 'label label-required' : 'label' }}"
		for="{{ $name }}">
		{{ $label }}
	</label>
@endif

<div class="relative">

	@isset($append)
		<span class="text-light-300 absolute left-0 top-2 text-sm">{{ $append }}</span>
	@endisset

	<input type="{{ $type }}"
		{{ $name ? "id={$name}" : '' }}
		{{ $name ? "name={$name}" : '' }}
		value="{{ old($name, $value ?? '') }}"
		{{ $required ?? false ? 'required' : '' }}
		{{ $attributes->merge(['class' => 'basic-input']) }}
		{{ $min ? "min={$min}" : '' }}
		{{ $max ? "max={$max}" : '' }}
		{{ $step ? "step={$step}" : '' }}
		autocomplete="off">

	@isset($prepend)
		<span class="text-dark-500 absolute right-2 top-[20%] text-sm">{{ $prepend }}</span>
	@endisset

</div>

@error($name)
	@include('components.inputs.partials.error')
@enderror
