@php
	$layout = config('rapid-pages.layouts.admin');
	$create_page_route = config('rapid-pages.routes.admin.pages.create');
	$create_sections_route = config('rapid-pages.routes.admin.sections.create');
@endphp

<x-dynamic-component component="{{ $layout }}">

	<x-slot name="header">
		<div class="grid grid-cols-2 items-center justify-between gap-6">
			<h2 class="mb-0 text-xl font-semibold leading-tight text-gray-800">
				Pages
			</h2>
			<div class="text-right">
				<a href="{{ $create_page_route }}"
					class="btn btn-primary">Create Page</a>

				<a href="{{ $create_sections_route }}"
					class="btn btn-primary">Create Section</a>
			</div>
		</div>
	</x-slot>

	<section class="py-12">
		<div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
			<sl-tab-group>

				<sl-tab slot="nav"
					panel="pages">Pages</sl-tab>

				<sl-tab slot="nav"
					panel="sections">Sections</sl-tab>

				<sl-tab-panel name="pages">
					<x-rapid-pages::page-index :pages="$pages" />
				</sl-tab-panel>

				<sl-tab-panel name="sections">
					<x-rapid-pages::section-index :sections="$sections" />
				</sl-tab-panel>

			</sl-tab-group>
		</div>
	</section>

</x-dynamic-component>
