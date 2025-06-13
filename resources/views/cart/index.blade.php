<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Shopping Cart</h2>
    </x-slot>

    <div class="p-6 bg-gray-100 min-h-screen">
        @php
        $cart = session('cart', []);
        $cartCount = collect($cart)->sum('quantity');
        $cartTotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        @endphp

        @if(count($cart) > 0)
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center border-b pb-3 mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Your Shopping Cart</h3>
                    <span class="text-sm text-gray-500">{{ $cartCount }} item(s)</span>
                </div>

                <div class="space-y-6">
                    @foreach($cart as $id => $item)
                    <div class="grid grid-cols-12 gap-4 items-center border-b pb-5">
                        <!-- Image + Details -->
                        <div class="col-span-12 md:col-span-6 flex items-center gap-4">
                            @if(!empty($item['image']))
                            <img src="{{ asset('storage/' . $item['image']) }}" alt="Product Image"
                                class="w-20 h-20 object-cover rounded border">
                            @else
                            <div
                                class="w-20 h-20 bg-gray-100 flex items-center justify-center border rounded text-gray-400">
                                No Image
                            </div>
                            @endif

                            <div>
                                <p class="text-lg font-semibold text-gray-800">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-500">₹ {{ number_format($item['price'], 2) }}</p>
                                <form method="POST" action="{{ route('users.cart.remove', $id) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-1.5 text-sm bg-red-500 hover:bg-red-600 text-white rounded-md transition">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Quantity Section -->
                        <div class="col-span-6 md:col-span-3 flex items-center justify-center gap-3">
                            <button type="button"
                                class="decrease bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded text-lg font-bold transition"
                                data-id="{{ $id }}">−</button>

                            <input type="text" name="quantity" readonly
                                class="quantity w-12 text-center border rounded text-sm py-1"
                                value="{{ $item['quantity'] }}" data-id="{{ $id }}">

                            <button type="button"
                                class="increase bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded text-lg font-bold transition"
                                data-id="{{ $id }}">+</button>

                            <!-- Hidden price for JS -->
                            <input type="hidden" class="item-price" data-id="{{ $id }}" value="{{ $item['price'] }}">
                        </div>

                        <!-- Per Product Total -->
                        <div class="col-span-6 md:col-span-3 text-right font-semibold text-gray-800 item-total"
                            data-id="{{ $id }}">
                            ₹ {{ number_format($item['price'] * $item['quantity'], 2) }}
                        </div>

                    </div>
                    @endforeach
                </div>

                <div class="pt-6">
                    <a href="{{ route('dashboard') }}"
                        class="text-green-600 hover:underline text-sm flex items-center gap-1">
                        ← Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow p-6 space-y-5">
                <h4 class="text-lg font-bold text-gray-800 border-b pb-3">Order Summary</h4>

                <div class="flex justify-between text-sm border-b pb-2">
                    <span>Items ({{ $cartCount }})</span>
                    <span id="subtotal">₹ {{ number_format($cartTotal, 2) }}</span>
                </div>

                <div class="flex justify-between items-center text-sm border-b py-2">
                    <label for="shipping" class="text-gray-700">Shipping</label>
                    <select id="shipping" name="shipping" class="text-sm border rounded px-3 py-1">
                        <option value="standard">Standard – ₹50.00</option>
                        <option value="express">Express – ₹100.00</option>
                    </select>
                </div>

                <div>
                    <label for="promo" class="text-sm font-medium block mb-1 text-gray-700">Promo Code</label>
                    <input type="text" id="promo" name="promo"
                        class="w-full border rounded px-3 py-2 text-sm mb-2 focus:ring focus:ring-green-200"
                        placeholder="Enter your code">
                    <button type="button"
                        class="w-full bg-gray-800 text-white py-2 text-sm rounded hover:bg-gray-900 transition">
                        Apply
                    </button>
                </div>

                <div class="flex justify-between font-semibold text-base border-t pt-3">
                    <span>Total</span>
                    <span id="cart-total">₹ {{ number_format($cartTotal + 50, 2) }}</span>
                </div>

                <button
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 text-sm font-semibold rounded shadow transition">
                    Proceed to Checkout
                </button>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="flex flex-col items-center justify-center bg-white p-10 rounded-xl shadow text-center space-y-4">
            <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="Empty Cart"
                class="w-24 h-24 opacity-60">
            <p class="text-gray-600 text-lg">Your cart is empty.</p>
            <a href="{{ route('dashboard') }}" class="inline-block mt-2 text-green-600 hover:underline text-sm">←
                Continue Shopping</a>
        </div>
        @endif
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</x-app-layout>