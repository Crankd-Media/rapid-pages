@php
	$layout = config('rapid-pages.layouts.app');
@endphp

<x-dynamic-component component="{{ $layout }}">

	<main>
		<x-rapid-pages::show-page :page="$page" />
	</main>

</x-dynamic-component>
