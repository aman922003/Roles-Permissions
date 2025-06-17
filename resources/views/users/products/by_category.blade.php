<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">
            Products in {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <div
                            class="bg-white shadow-xl rounded-2xl overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col">

                            {{-- Product Image --}}
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 flex items-center justify-center bg-gray-100 text-gray-400 italic">
                                    No Image Available
                                </div>
                            @endif

                            {{-- Product Details --}}
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ Str::limit($product->description, 60) }}
                                    </p>
                                    <p class="text-xl font-bold text-blue-600 mt-2">
                                        ₹{{ number_format($product->price, 2) }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">In Stock: {{ $product->quantity }}</p>
                                </div>

                                {{-- Add to Cart Form --}}
                                <form action="{{ route('users.addToCart', $product->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    <div class="flex items-center gap-2 mb-3">
                                        <label for="quantity_{{ $product->id }}" class="text-sm text-gray-700">Qty:</label>
                                        <input type="number" name="qty" id="quantity_{{ $product->id }}" value="1" min="1"
                                            max="{{ $product->quantity }}"
                                            class="w-16 border border-gray-300 rounded px-2 py-1 text-sm">
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-6 rounded shadow text-gray-600 text-center">
                    No products found in this category.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
