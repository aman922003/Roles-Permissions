<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div
                class="flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 text-sm font-medium px-4 py-3 rounded-lg shadow-sm">
                <i class="fas fa-circle-check text-green-600 text-base"></i>
                <span>
                    {{ __("You're logged in!") }}
                </span>
            </div>

        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Management Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- User Management Card -->
                @can('manage user')
                <div
                    class="bg-white rounded-2xl shadow-lg p-8 text-center border border-blue-100 hover:shadow-xl transition duration-300">
                    <div class="flex justify-center mb-5">
                        <i class="fas fa-users fa-3x text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 flex items-center justify-center gap-2">
                        <i class="fas fa-user text-blue-500"></i>
                        User Management
                    </h3>
                    <p class="text-gray-500 mb-6">Manage all registered users, update details, and control access.</p>
                    <a href="{{ route('users.index') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition">
                        Manage Users
                    </a>
                </div>
                @endcan
                <!-- Roles & Permissions Card -->
                @can('manage roles&permission')
                <div
                    class="bg-white rounded-2xl shadow-lg p-8 text-center border border-green-100 hover:shadow-xl transition duration-300">

                    <div class="flex justify-center mb-5">
                        <i class="fas fa-user-shield fa-3x text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 flex items-center justify-center gap-2">
                        <i class="fas fa-lock text-green-500"></i>
                        Roles & Permissions
                    </h3>
                    <p class="text-gray-500 mb-6">Assign roles and set permissions for system-wide access control.</p>
                    <a href="{{ route('roles.index') }}"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg transition">
                        Manage Roles
                    </a>
                </div>
                @endcan
            </div>


            <!-- All User Products -->
            @can('view product list')
            <h2 class="text-2xl font-bold text-gray-800 mb-6">All Products</h2>

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
                                ₹
                                {{ number_format($product->price, 2) }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">In Stock:
                                {{ $product->quantity }}
                            </p>
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
            @endcan


        </div>
    </div>
</x-app-layout>