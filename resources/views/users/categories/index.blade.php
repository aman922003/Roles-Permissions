<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Browse Categories</h2>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 px-4">
            @foreach ($categories as $category)
                <a href="{{ route('users.productsByCategory', $category->id) }}"
                   class="bg-white shadow-sm hover:shadow-lg transition rounded-xl p-6 text-center border border-gray-200">
                    <h3 class="text-lg font-semibold text-blue-600">{{ $category->name }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
