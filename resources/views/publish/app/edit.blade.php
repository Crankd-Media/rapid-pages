@php
	$layout = config('rapid-pages.layouts.app');
@endphp

<x-dynamic-component component="{{ $layout }}">

	<main class="mb-10">
		<x-rapid-pages::edit-page :page="$page" />
	</main>

</x-dynamic-component>
