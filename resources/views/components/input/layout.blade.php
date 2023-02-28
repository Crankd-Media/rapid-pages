@props(['layout' => 'basic', 'label', 'name', 'icon' => 'arrow-circle-down'])


@if ($layout == 'basic')
	<div {{ $attributes->merge(['class' => 'my-4']) }}>
		{{ $slot }}
	</div>
@endif
