<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Checkout</h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6 min-h-screen bg-gray-100">
        {{-- Shipping Details --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-sm border space-y-6">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Shipping Details</h2>

            <form action="#" method="POST" class="space-y-6">
                @csrf

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Address</label>
                        <textarea name="shipping_address" required rows="3"
                            class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Region</label>
                        <input type="text" name="shipping_region" required
                            class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="shipping_city" required
                            class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="shipping_phone" required
                            class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Country</label>
                        <input type="text" name="shipping_country" required
                            class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Zip Code</label>
                        <input type="text" name="shipping_zip" required
                            class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>
                </div>
        </div>

        {{-- Order Summary --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border space-y-6 h-fit">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Your Order</h2>

            <div class="space-y-3 text-sm text-gray-700">
                @forelse ($cart as $id => $item)
                <div class="flex justify-between items-center border-b pb-1">
                    <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                    <span class="font-medium">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                </div>
                @empty
                <p class="text-gray-500">Your cart is empty.</p>
                @endforelse
            </div>

            <div class="border-t pt-3 space-y-2 text-sm text-gray-700">
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

            {{-- Shipping Methods --}}
            <div class="pt-4 space-y-1 text-sm text-gray-700">
                <p class="font-medium text-gray-800">Shipping Method</p>
                <label class="flex items-center gap-2">
                    <input type="radio" name="shipping_method" value="flat" class="accent-green-600"> Flat Rate
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="shipping_method" value="free" class="accent-green-600"> Free Shipping
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="shipping_method" value="express" class="accent-green-600"> Express
                    Delivery
                </label>
            </div>

            {{-- Payment Methods --}}
            <div class="pt-4 space-y-1 text-sm text-gray-700">
                <p class="font-medium text-gray-800">Payment Method</p>
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment_method" value="paypal" class="accent-green-600"> PayPal
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment_method" value="card" class="accent-green-600"> Credit Card
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment_method" value="bank" class="accent-green-600"> Bank Transfer
                </label>
            </div>

            <p class="text-xs text-gray-500">
                Use your Order ID as payment reference. Your order won’t ship until payment clears.
            </p>

            <a href="{{ route('admin.orders') }}"
                class="w-full mt-4 inline-block text-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-md font-semibold shadow transition">
                Place Order
            </a>

            </form>
        </div>
    </div>
</x-app-layout>