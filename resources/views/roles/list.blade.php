<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            @can('create roles')
            <a href="{{ route('roles.create') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="w-full table-auto border-collapse rounded-lg overflow-hidden shadow-md">
                <thead class="bg-gray-100 text-left text-gray-700 uppercase text-sm tracking-wider">
                    <tr>
                        <th class="px-6 py-4 border-b">#</th>
                        <th class="px-6 py-4 border-b">Name</th>
                        <th class="px-6 py-4 border-b">Permissions</th>
                        <th class="px-6 py-4 border-b">Created</th>
                        <th class="px-6 py-4 border-b text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-gray-800">
                    @if ($roles->isNotEmpty())
                        @foreach ($roles as $role)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4">
                                    {{ $role->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $role->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $role->permissions->pluck('name')->implode(', ') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $role->created_at }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex space-x-2">
                                        @can('edit roles')
                                            <a href="{{ route('roles.edit', $role->id) }}"
                                                class="inline-block bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
                                                Edit
                                            </a>
                                        @endcan
                                        @can('delete roles')
                                            <a href="javascript:void(0)" onclick="deletePermission({{ $role->id }})"
                                                class="inline-block bg-red-700 hover:bg-red-800 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
                                                Delete
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-3">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id) {
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        url: '/roles/' + id,
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            window.location.href = "{{ route('roles.index') }}";
                        }
                    });
                }
            }   
        </script>
    </x-slot>
</x-app-layout>