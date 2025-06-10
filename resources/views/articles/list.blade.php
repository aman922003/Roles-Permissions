<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles') }}
            </h2>
            <a href="{{ route('articles.create') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition duration-200 ease-in-out">Create</a>
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
                        <th class="px-6 py-4 border-b">Text</th>
                        <th class="px-6 py-4 border-b">Auther</th>
                        <th class="px-6 py-4 border-b">Created</th>
                        <th class="px-6 py-4 border-b text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-gray-800">
                    @if ($articles->isNotEmpty())
                    @foreach ($articles as $article)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4">
                            {{ $article->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $article->title }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $article->text }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $article->auther }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $article->created_at }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex space-x-2">
                                @can('edit articles')
                                <a href="{{ route('articles.edit', $article->id) }}"
                                    class="inline-block bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
                                    Edit
                                </a>
                                @endcan
                                @can('delete articles')
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-block bg-red-700 hover:bg-red-800 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
                                        Delete
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-3">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
        function deletePermission(id) {
            if (confirm("Are you sure want to delete?")) {
                $.ajax({
                    url: '/articles/' + id, // Updated URL to match route
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // Send token as data
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            // Save message in localStorage temporarily
                            // localStorage.setItem('successMessage', response.message);
                            window.location.href = "{{ route('articles.index') }}";
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            }
        }
        </script>
    </x-slot>
</x-app-layout>