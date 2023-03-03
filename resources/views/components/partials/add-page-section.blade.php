<sl-dialog x-data="addPageSection()"
	label="Add Section"
	class="dialog-overview"
	@add-new-section.window="$refs.dialog.show();"
	x-ref="dialog">


	<div @add-new-section.window="setUpSections($event.detail)"
		class="pt-8">

		<ul role="list"
			class="flex flex-col gap-4 px-6 pb-8">

			<template x-for="(section, section_index) in sections"
				:key="index">
				<li @click="$dispatch('add-section', {section, index, position} ); $refs.dialog.hide() "
					class="group flex cursor-pointer items-center gap-4 rounded-md border border-gray-300 p-4 hover:border-indigo-600 hover:bg-indigo-50">
					<div class="flex-1">
						<p class="text-sm font-medium group-hover:text-indigo-600"
							x-text="section.name">Banner</p>
						<p class="text-sm text-gray-500">Add a full-width banner</p>
					</div>
					<div class="relative h-[56px] w-[100px] flex-shrink-0">
						<span
							style="box-sizing: border-box; display: block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: absolute; inset: 0px;">
							<img :alt="section.slug"
								:src="'/storage/sections/' + section.slug + '.jpg'"
								decoding="async"
								data-nimg="fill"
								class="rounded"
								style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%; object-fit: cover;">
						</span>
					</div>
				</li>
			</template>

		</ul>

	</div>

</sl-dialog>
