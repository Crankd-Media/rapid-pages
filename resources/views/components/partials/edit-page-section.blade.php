<sl-drawer x-data="editPageSection()"
	@edit-page-section.window="section = $event.detail; $refs.drawer.show();"
	label="Edit Section"
	class="drawer-custom-size"
	style="--size: 80vw;"
	x-ref="drawer">


	<div class="flex h-full flex-col items-stretch">

		{{-- Body --}}
		<div class="relative flex flex-1 flex-col px-4 py-6 sm:px-6">
			<template x-if="section_fields">
				<div class="divide-y pb-6">
					<template x-for="field in section_fields"
						:key="$id()">
						<div class="py-6"
							x-log="field">
							<template x-if="field.type == 'text'">
								<x-rapid-custom-fields::field-input.text />
							</template>

							<template x-if="field.type == 'textarea'">
								<x-rapid-custom-fields::field-input.textarea />
							</template>

							<template x-if="field.type == 'link'">
								<x-rapid-custom-fields::field-input.link />
							</template>

							<template x-if="field.type == 'image'">
								<x-rapid-custom-fields::field-input.image />
							</template>

							<template x-if="field.type == 'repeater'">
								<x-rapid-custom-fields::field-input.repeater />
							</template>

							<template x-if="field.type == 'checkbox'">
								<x-rapid-custom-fields::field-input.checkbox />
							</template>
						</div>

					</template>
				</div>
			</template>
		</div>

		{{-- Footer --}}
		<div slot="footer"
			class="sticky left-0 right-0 bottom-0 z-50 flex items-center justify-between gap-3 border-t border-gray-100 bg-white pt-4 opacity-100 transition-all duration-300">
			<p class="text-sm font-medium">Save changes?</p>
			<div class="flex items-center gap-3">
				<button @click="discardChanges();$refs.drawer.hide();"
					class="secondary">Discard</button>
				<button @click="updateSectionSettings(); $refs.drawer.hide();"
					class="primary relative">Publish</button>
			</div>
		</div>

	</div>



</sl-drawer>
