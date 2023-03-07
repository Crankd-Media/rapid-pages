@foreach ($page->getSections() as $section)
	<div x-data="{ item: {{ $section }} }">
		<x-dynamic-component :component="'frontend.sections.' . $section->slug"
			:item="$section" />
	</div>
@endforeach
