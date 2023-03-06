<div class="border-b border-gray-200 shadow sm:rounded-lg">
	<table class="min-w-full divide-y divide-gray-200">
		<thead class="bg-gray-50">
			<tr>
				<th scope="col"
					class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
				</th>
				<th scope="col"
					class="relative px-6 py-3">
					<span class="sr-only">Edit</span>
				</th>
			</tr>
		</thead>
		@if ($pages->count())
			<tbody class="divide-y divide-gray-200 bg-white">
				@foreach ($pages as $page)
					<tr>
						<td>
							<a href="{{ route('admin.pages.edit', $page) }}">
								<div class="flex items-center">
									<div class="ml-4">
										<div class="text-sm font-medium text-gray-900">
											{{ $page->title }}
										</div>
										<div class="text-sm text-gray-500">
											{{ $page->slug }}
										</div>
									</div>
								</div>
							</a>
						</td>
						<td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">

							<a href="{{ route('pages.show', $page) }}"
								target="_blank"
								class="mb-2 mr-2 text-indigo-600 hover:text-indigo-900">View</a>

							<form class="inline-block"
								action="{{ route('admin.pages.destroy', $page) }}"
								method="POST"
								data-confirm="true">
								@method('DELETE')
								<input type="hidden"
									name="_token"
									value="{{ csrf_token() }}">
								<input type="submit"
									class="mb-2 mr-2 bg-white text-red-600 hover:text-red-900"
									value="Delete">
							</form>
						</td>
					</tr>
				@endforeach

			</tbody>
		@endif
	</table>
</div>
