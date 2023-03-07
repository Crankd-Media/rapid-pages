@php
	$editing = isset($section) ? true : false;
	$store_sections_route = config('rapid-pages.routes.admin.sections.store');
	$update_sections_route = config('rapid-pages.routes.admin.sections.update');
	$route = isset($section) ? route($update_sections_route, $section) : route($store_sections_route);
@endphp


<section class="py-12">
	<div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

		<form action="{{ $route }}"
			method="POST"
			enctype="multipart/form-data">
			@if ($editing)
				@method('PATCH')
			@endif
			@csrf
			<div class="space-y-4">

				<x-rapid-ui::input.text name="name"
					label="Name"
					:value="old('name', $editing ? $section->name : '')" />

				<x-rapid-ui::input.text name="slug"
					label="Slug"
					:value="old('slug', $editing ? $section->slug : '')" />

				<button type="submit"
					class="btn btn-primary">Save</button>
			</div>

		</form>

		@if ($editing)
			<x-rapid-custom-fields::render-custom-fields :route="route($update_sections_route, $section)"
				:fields="$section->fields" />
		@endif

	</div>
</section>
