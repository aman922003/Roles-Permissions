<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            @can('create users')
                <a href="{{ route('users.create') }}"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition">
                    Create
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-message />

            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="w-full table-auto text-sm text-left text-gray-800">
                    <thead class="bg-gray-100 uppercase text-gray-600 tracking-wider">
                        <tr>
                            <th class="px-6 py-4 border-b">#</th>
                            <th class="px-6 py-4 border-b">Name</th>
                            <th class="px-6 py-4 border-b">Email</th>
                            <th class="px-6 py-4 border-b">Password</th>
                            <th class="px-6 py-4 border-b">Age</th>
                            <th class="px-6 py-4 border-b">Gender</th>
                            <th class="px-6 py-4 border-b">Created</th>
                            <th class="px-6 py-4 border-b text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    {{ $user->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 text-gray-400 italic">Hidden</td>
                                <td class="px-6 py-4">
                                    {{ $user->age }}
                                </td>
                                <td class="px-6 py-4 capitalize">
                                    {{ $user->gender }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-3">
                                        @can('edit users')
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-md text-sm font-medium shadow">
                                                Edit
                                            </a>
                                        @endcan
                                        @can('delete users')
                                            <a href="javascript:void(0)" onclick="deletePermission({{ $user->id }})"
                                                class="bg-red-700 hover:bg-red-800 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
                                                Delete
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id) {
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        url: '/users/' + id,
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            window.location.href = "{{ route('users.index') }}";
                        }
                    });
                }
            }   
        </script>
    </x-slot>
</x-app-layout>