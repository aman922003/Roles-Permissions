<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
            <a href="{{ route('admin.products.create') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-md transition inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="w-full table-auto text-sm text-left text-gray-800">
                    <thead class="bg-gray-100 uppercase text-gray-600 tracking-wider">
                        <tr>
                            <th class="px-6 py-4 border-b">Name</th>
                            <th class="px-6 py-4 border-b">Description</th>
                            <th class="px-6 py-4 border-b">Category</th>
                            <th class="px-6 py-4 border-b">Price</th>
                            <th class="px-6 py-4 border-b">Image</th>
                            <th class="px-6 py-4 border-b text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $prod)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">{{ $prod->name }}</td>
                            <td class="px-6 py-4">{{ $prod->description }}</td>
                            <td class="px-6 py-4">{{ $prod->category->name }}</td>
                            <td class="px-6 py-4">₹{{ number_format($prod->price, 2) }}</td>
                            <td class="px-6 py-4">
                                @if($prod->image)
                                <img src="{{ asset('storage/' . $prod->image) }}"
                                    class="w-16 h-16 rounded object-cover border" alt="Product Image">
                                @else
                                <span class="text-gray-400 italic">No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="{{ route('admin.products.edit', $prod->id) }}"
                                        class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-md text-sm font-medium shadow">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $prod->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md text-sm font-medium shadow">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No products found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="my-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
    </script>
</x-app-layout>