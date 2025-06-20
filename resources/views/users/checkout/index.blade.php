<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Checkout</h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6 min-h-screen bg-gray-100">
        {{-- Shipping Details --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-md border space-y-6">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-4">Shipping Details</h2>

            <form id="checkoutForm" action="{{ route('users.placeorder') }}" method="POST" class="space-y-6" novalidate>
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Address full width --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="address" id="address" rows="3" required
                            class="w-full border border-gray-300 px-4 py-3 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 resize-none"></textarea>
                        <div id="address-error" class="text-red-500 text-xs mt-1 hidden">Address is required</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                        <input type="text" name="region" id="region" required
                            class="w-full border border-gray-300 px-4 py-3 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <div id="region-error" class="text-red-500 text-xs mt-1 hidden">Region is required</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" name="city" id="city" required
                            class="w-full border border-gray-300 px-4 py-3 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <div id="city-error" class="text-red-500 text-xs mt-1 hidden">City is required</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" id="phone" required
                            class="w-full border border-gray-300 px-4 py-3 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <div id="phone-error" class="text-red-500 text-xs mt-1 hidden">Valid phone number is required
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <input type="text" name="country" id="country" required
                            class="w-full border border-gray-300 px-4 py-3 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <div id="country-error" class="text-red-500 text-xs mt-1 hidden">Country is required</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
                        <input type="text" name="zip" id="zip" required
                            class="w-full border border-gray-300 px-4 py-3 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <div id="zip-error" class="text-red-500 text-xs mt-1 hidden">Zip code is required</div>
                    </div>
                </div>
        </div>

        {{-- Order Summary --}}
        <div class="bg-white p-8 rounded-2xl shadow-md border space-y-6 h-fit">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-4">Your Order</h2>

            <div class="space-y-3 text-sm text-gray-700">
                @forelse ($cart as $id => $item)
                <div class="flex justify-between border-b pb-2">
                    <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                    <span class="font-medium">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                </div>
                @empty
                <p>Your cart is empty.</p>
                @endforelse
            </div>

            <div class="border-t pt-4 space-y-2 text-sm text-gray-700">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax (18%)</span>
                    <span>₹{{ number_format($tax, 2) }}</span>
                </div>
                <div class="flex justify-between font-semibold text-green-700 border-t pt-3 text-base">
                    <span>Total</span>
                    <span>₹{{ number_format($total, 2) }}</span>
                </div>
            </div>

            {{-- Hidden Fields --}}
            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
            <input type="hidden" name="tax" value="{{ $tax }}">
            <input type="hidden" name="total" value="{{ $total }}">

            {{-- Shipping Method --}}
            <div class="pt-4">
                <p class="font-medium text-gray-800 mb-2">Shipping Method</p>
                <div class="space-y-1 text-sm">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="shipping_method" value="flat" class="accent-green-600" required> Flat
                        Rate
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="shipping_method" value="free" class="accent-green-600"> Free Shipping
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="shipping_method" value="express" class="accent-green-600"> Express
                        Delivery
                    </label>
                </div>
                <div id="shipping_method-error" class="text-red-500 text-xs mt-1 hidden">Please select a shipping method
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="pt-4">
                <p class="font-medium text-gray-800 mb-2">Payment Method</p>
                <div class="space-y-1 text-sm">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="payment_method" value="paypal" class="accent-green-600" required>
                        PayPal
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="payment_method" value="card" class="accent-green-600"> Credit Card
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="payment_method" value="bank" class="accent-green-600"> Bank Transfer
                    </label>
                </div>
                <div id="payment_method-error" class="text-red-500 text-xs mt-1 hidden">Please select a payment method
                </div>
            </div>

            <button type="submit"
                class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold shadow transition">
                Place Order
            </button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/ecommerce-validation.js') }}"></script>
</x-app-layout>