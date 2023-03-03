<div>
	<div class="group relative">

		{{-- ADD SECTION TOP --}}
		<div
			class="pointer-events-none absolute -top-[1px] right-1/2 z-[100] w-full translate-x-1/2 border-2 border-indigo-500 opacity-0 group-hover:pointer-events-auto group-hover:opacity-100">
			<button @click.prevent="$dispatch('add-new-section', { index : index,  position: 'before' })"
				class="primary sm absolute -bottom-1/2 right-1/2 translate-x-1/2 translate-y-1/2 font-sans !ring-0 !ring-offset-0">Add
				section +
			</button>
		</div>

		{{-- ACTION LINKS  --}}
		<div
			class="absolute z-[90] flex h-full w-full items-center justify-center border-r-2 border-l-2 border-indigo-500 bg-black bg-opacity-50 opacity-0 transition-all group-hover:opacity-100">
			<div class="flex items-center gap-0.5 rounded-md bg-white p-2">
				{{-- Edit --}}
				<button @click.prevent="$dispatch('edit-page-section', item )"
					class="rounded-md p-2.5 text-indigo-700 hover:bg-indigo-100">
					<svg xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="h-4 w-4">
						<path stroke-linecap="round"
							stroke-linejoin="round"
							d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
					</svg>
				</button>
				{{-- Duplicate --}}
				<button @click="duplicate(index)"
					class="rounded-md p-2.5 text-indigo-700 hover:bg-indigo-100">
					<svg xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="h-4 w-4">
						<path stroke-linecap="round"
							stroke-linejoin="round"
							d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
					</svg>
				</button>
				{{-- Move Up  --}}
				<button @click="moveUp(index)"
					class="rounded-md p-2.5 text-indigo-700 hover:bg-indigo-100">
					<svg xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="h-4 w-4">
						<path stroke-linecap="round"
							stroke-linejoin="round"
							d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
					</svg>
				</button>
				{{-- Move Down --}}
				<button @click="moveDown(index)"
					class="rounded-md p-2.5 text-indigo-700 hover:bg-indigo-100">
					<svg xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="h-4 w-4">
						<path stroke-linecap="round"
							stroke-linejoin="round"
							d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
					</svg>
				</button>
				{{-- Remove --}}
				<button @click="remove(index)"
					class="rounded-md p-2.5 text-red-700 hover:bg-red-100">
					<svg xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="h-4 w-4">
						<path stroke-linecap="round"
							stroke-linejoin="round"
							d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
		</div>

		{{-- Rendew The Section Design --}}
		@foreach ($sections as $section)
			<template x-if="item.slug == '{{ $section->slug }}'">
				{{-- <x-dynamic-component :component="'frontend.sections.' . $section->slug" /> --}}
				<div class="py-16 text-center">
					{{ $section->slug }}
				</div>
			</template>
		@endforeach

		{{-- ADD SECTION BOTTOM --}}
		<div
			class="pointer-events-none absolute -bottom-[1px] right-1/2 z-[100] w-full translate-x-1/2 border-2 border-indigo-500 opacity-0 group-hover:pointer-events-auto group-hover:opacity-100">
			<button @click.prevent="$dispatch('add-new-section', { index : index,  position: 'after' })"
				class="primary sm absolute -bottom-1/2 right-1/2 translate-x-1/2 translate-y-1/2 font-sans !ring-0 !ring-offset-0">Add
				section
				+
			</button>
		</div>


	</div>
</div>
