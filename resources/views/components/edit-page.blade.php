@php
	$sections = App\Models\Section::get();
	foreach ($sections as $section) {
	    $values = [];
	    $fields = $section->fields;
	    if (empty($fields)) {
	        continue;
	    }
	    foreach ($fields as $field) {
	        $field->value = null;
	        if ($field->type == 'link' && empty($field->value)) {
	            $field->value = [
	                'label' => $field->title,
	                'show' => false,
	                'target' => '_self',
	                'type' => 'link',
	                'url' => '',
	                'title' => '',
	            ];
	        }
	        $values[$field->key] = $field;
	    }
	    $section->fieldValues = $values;
	}
	
	$page_sections = $page->getSections();
	
	$update_page_route = config('rapid-pages.routes.admin.pages.update');
	$route = route($update_page_route, $page);
@endphp


<div x-data="editPage({{ json_encode($page) }}, {{ json_encode($page_sections) }}, {{ json_encode($sections) }}, {{ json_encode($route) }})"
	@add-section.window="addSection($event.detail)">

	{{-- LOOP PAGE SECTIONS --}}
	<template x-for="(item, index) in items"
		:key="$id('page-section')">
		<x-rapid-pages::partials.section-wrapper :sections="$sections" />
	</template>

	{{-- PAGE SAVE ACTIONS --}}
	<div
		class="fixed bottom-0 left-0 right-0 z-[100] flex items-center justify-between gap-3 border-t border-gray-100 bg-gray-50 px-6 pt-4 pb-9 transition-all duration-300 md:pb-4">
		<p class="text-sm font-medium">Unsaved changes</p>
		<div class="flex items-center gap-3">
			<button @click="discardChangers()"
				class="secondary">Discard</button>

			<button @click="updatePage()"
				class="primary relative">Save</button>
		</div>
	</div>

	{{-- ADD PAGE SECTION MODAL --}}
	<x-rapid-pages::partials.add-page-section />

	{{-- EDIT PAGE SECTION MODAL --}}
	<x-rapid-pages::partials.edit-page-section />

	{{-- EDIT REPEATER ITEM --}}
	<x-rapid-custom-fields::edit-repeater-item />


</div>


{{-- TODO move this into Rapid UI --}}
<style>
	input[type=text],
	input[type=email],
	input[type=password],
	input[type=tel],
	input[type=url],
	textarea {
		display: block;
		width: 100%;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		border-radius: 0.375rem !important;
		border-width: 1px !important;
		--tw-border-opacity: 1 !important;
		border-color: rgba(209, 213, 219, var(--tw-border-opacity)) !important;
		padding: 0.625rem 0.75rem !important;
		font-size: 16px !important;
		line-height: 16px !important;
	}

	button.primary:not(.round) {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border-radius: .375rem;
		border-width: 1px;
		border-color: transparent;
		--tw-bg-opacity: 1;
		background-color: rgba(76, 53, 222, var(--tw-bg-opacity));
		padding: .625rem 1rem;
		font-size: 16px;
		line-height: 16px;
		font-weight: 400;
		--tw-text-opacity: 1;
		color: rgba(255, 255, 255, var(--tw-text-opacity));
		--tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05);
		box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
	}


	a.button.secondary:not(.round),
	button.secondary:not(.round) {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border-radius: .375rem;
		border-width: 1px;
		border-color: transparent;
		--tw-bg-opacity: 1;
		background-color: rgba(228, 224, 255, var(--tw-bg-opacity));
		padding: .625rem 1rem;
		font-size: 16px;
		line-height: 16px;
		font-weight: 400;
		--tw-text-opacity: 1;
		color: rgba(67, 48, 192, var(--tw-text-opacity));
		--tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05);
		box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
	}

	a.button.secondary:not(.round):hover,
	button.secondary:not(.round):hover {
		--tw-bg-opacity: 1;
		background-color: rgba(207, 200, 254, var(--tw-bg-opacity))
	}

	a.button.secondary:not(.round):focus,
	button.secondary:not(.round):focus {
		outline: 2px solid transparent;
		outline-offset: 2px;
		--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
		--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
		box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
		--tw-ring-opacity: 1;
		--tw-ring-color: rgba(207, 200, 254, var(--tw-ring-opacity));
		--tw-ring-offset-width: 2px
	}

	@media (min-width: 1024px) {

		a.button.secondary:not(.round),
		button.secondary:not(.round) {
			font-size: 14px;
			line-height: 16px
		}
	}

	a.button.secondary:not(.round).xl,
	button.secondary:not(.round).xl {
		padding: .75rem 1rem;
		font-size: 1.25rem;
		line-height: 1.75rem
	}

	a.button.secondary:not(.round).lg,
	button.secondary:not(.round).lg {
		padding: .75rem 1rem;
		font-size: 16px;
		line-height: 16px
	}

	a.button.secondary:not(.round).sm,
	button.secondary:not(.round).sm {
		padding: .5rem .75rem;
		font-size: 14px;
		line-height: 16px
	}

	a.button.secondary:not(.round).xs,
	button.secondary:not(.round).xs {
		padding: .375rem .75rem;
		font-size: 12px;
		line-height: 16px
	}

	a.button.secondary:not(.round):disabled,
	button.secondary:not(.round):disabled {
		opacity: .6
	}



	.link,
	a.link {
		cursor: pointer;
		border-color: rgba(76, 53, 222, var(--tw-border-opacity));
		font-weight: 500;
		color: rgba(76, 53, 222, var(--tw-text-opacity))
	}

	.link,
	.link:hover,
	a.link,
	a.link:hover {
		--tw-border-opacity: 1;
		--tw-text-opacity: 1
	}

	.link:hover,
	a.link:hover {
		border-color: rgba(145, 130, 248, var(--tw-border-opacity));
		color: rgba(145, 130, 248, var(--tw-text-opacity))
	}

	.link.sm,
	a.link.sm {
		font-size: 12px;
		line-height: 16px
	}


	a.button.attention:not(.round),
	button.attention:not(.round) {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border-radius: .375rem;
		border-width: 1px;
		border-color: transparent;
		--tw-bg-opacity: 1;
		background-color: rgba(254, 226, 216, var(--tw-bg-opacity));
		padding: .625rem 1rem;
		font-size: 16px;
		line-height: 16px;
		font-weight: 400;
		--tw-text-opacity: 1;
		color: rgba(183, 60, 16, var(--tw-text-opacity));
		--tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05);
		box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
	}

	a.button.attention:not(.round):hover,
	button.attention:not(.round):hover {
		--tw-bg-opacity: 1;
		background-color: rgba(253, 200, 181, var(--tw-bg-opacity))
	}

	a.button.attention:not(.round):focus,
	button.attention:not(.round):focus {
		outline: 2px solid transparent;
		outline-offset: 2px;
		--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
		--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
		box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
		--tw-ring-opacity: 1;
		--tw-ring-color: rgba(253, 200, 181, var(--tw-ring-opacity));
		--tw-ring-offset-width: 2px
	}

	@media (min-width: 1024px) {

		a.button.attention:not(.round),
		button.attention:not(.round) {
			font-size: 14px;
			line-height: 16px
		}
	}

	a.button.attention:not(.round).xl,
	button.attention:not(.round).xl {
		padding: .75rem 1rem;
		font-size: 1.25rem;
		line-height: 1.75rem
	}

	a.button.attention:not(.round).lg,
	button.attention:not(.round).lg {
		padding: .75rem 1rem;
		font-size: 16px;
		line-height: 16px
	}

	a.button.attention:not(.round).sm,
	button.attention:not(.round).sm {
		padding: .5rem .75rem;
		font-size: 14px;
		line-height: 16px
	}

	a.button.attention:not(.round).xs,
	button.attention:not(.round).xs {
		padding: .375rem .75rem;
		font-size: 12px;
		line-height: 16px
	}

	a.button.attention:not(.round):disabled,
	button.attention:not(.round):disabled {
		opacity: .6
	}



	a.button.light:not(.round),
	body #buorgig,
	button.light:not(.round) {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border-radius: .375rem;
		border-width: 1px;
		--tw-border-opacity: 1;
		border-color: rgba(209, 213, 219, var(--tw-border-opacity));
		--tw-bg-opacity: 1;
		background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
		padding: .625rem 1rem;
		font-size: 16px;
		line-height: 16px;
		font-weight: 400;
		--tw-text-opacity: 1;
		color: rgba(107, 114, 128, var(--tw-text-opacity));
		--tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05);
		box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
	}

	a.button.light:not(.round):hover,
	body #buorgig:hover,
	button.light:not(.round):hover {
		--tw-bg-opacity: 1;
		background-color: rgba(249, 250, 251, var(--tw-bg-opacity))
	}

	a.button.light:not(.round):focus,
	body #buorgig:focus,
	button.light:not(.round):focus {
		outline: 2px solid transparent;
		outline-offset: 2px;
		--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
		--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
		box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
		--tw-ring-opacity: 1;
		--tw-ring-color: rgba(119, 100, 242, var(--tw-ring-opacity));
		--tw-ring-offset-width: 2px
	}

	@media (min-width: 1024px) {

		a.button.light:not(.round),
		body #buorgig,
		button.light:not(.round) {
			font-size: 14px;
			line-height: 16px
		}
	}

	a.button.light:not(.round).xl,
	body #buorgig.xl,
	button.light:not(.round).xl {
		padding: .75rem 1rem;
		font-size: 1.25rem;
		line-height: 1.75rem
	}

	a.button.light:not(.round).lg,
	body #buorgig.lg,
	button.light:not(.round).lg {
		padding: .75rem 1rem;
		font-size: 16px;
		line-height: 16px
	}

	a.button.light:not(.round).sm,
	body #buorgig.sm,
	button.light:not(.round).sm {
		padding: .5rem .75rem;
		font-size: 14px;
		line-height: 16px
	}

	a.button.light:not(.round).xs,
	body #buorgig.xs,
	button.light:not(.round).xs {
		padding: .375rem .75rem;
		font-size: 12px;
		line-height: 16px
	}

	a.button.light:not(.round):disabled,
	body #buorgig:disabled,
	button.light:not(.round):disabled {
		opacity: .6
	}
</style>
