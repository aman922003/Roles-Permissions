<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">
            Browse Categories
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($categories as $category)
                <a href="{{ route('users.productsByCategory', $category->id) }}"
                    class="bg-white shadow-xl rounded-2xl overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col">

                    {{-- Category Image --}}
                    @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                        class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 italic">
                        No Image Available
                    </div>
                    @endif

                    {{-- Category Details --}}
                    <div class="p-4 text-center flex-1 flex flex-col justify-center">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-gray-500">View Products</p>
                    </div>
                </a>
                @empty
                <p class="text-center col-span-full text-gray-600 text-lg mt-10">
                    No categories available.
                </p>
                @endforelse
            </div>
        </div>
    </div>
   
</x-app-layout>