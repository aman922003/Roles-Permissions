<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Checkout</h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6 min-h-screen bg-gray-100">
        {{-- Shipping Details --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-sm border space-y-6">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Shipping Details</h2>

            <form action="{{ route('users.placeorder') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Address</label>
                        <textarea name="address" required rows="3"
                            class="w-full border px-3 py-2 rounded-md resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Region</label>
                        <input type="text" name="region" required class="w-full border px-3 py-2 rounded-md">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="city" required class="w-full border px-3 py-2 rounded-md">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" required class="w-full border px-3 py-2 rounded-md">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Country</label>
                        <input type="text" name="country" required class="w-full border px-3 py-2 rounded-md">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Zip Code</label>
                        <input type="text" name="zip" required class="w-full border px-3 py-2 rounded-md">
                    </div>
                </div>
        </div>

        {{-- Order Summary --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border space-y-6 h-fit">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Your Order</h2>

            <div class="space-y-3 text-sm text-gray-700">
                @forelse ($cart as $id => $item)
                    <div class="flex justify-between border-b pb-1">
                        <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                        <span class="font-medium">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @empty
                    <p>Your cart is empty.</p>
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

            {{-- Hidden Fields --}}
            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
            <input type="hidden" name="tax" value="{{ $tax }}">
            <input type="hidden" name="total" value="{{ $total }}">

            {{-- Shipping Method --}}
            <div class="pt-4">
                <p class="font-medium text-gray-800">Shipping Method</p>
                <label class="flex items-center gap-2">
                    <input type="radio" name="shipping_method" value="flat" required class="accent-green-600"> Flat Rate
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="shipping_method" value="free" class="accent-green-600"> Free Shipping
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="shipping_method" value="express" class="accent-green-600"> Express Delivery
                </label>
            </div>

            {{-- Payment Method --}}
            <div class="pt-4">
                <p class="font-medium text-gray-800">Payment Method</p>
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment_method" value="paypal" required class="accent-green-600"> PayPal
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment_method" value="card" class="accent-green-600"> Credit Card
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment_method" value="bank" class="accent-green-600"> Bank Transfer
                </label>
            </div>

            <button type="submit"
                class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white py-3 rounded-md font-semibold shadow transition">
                Place Order
            </button>

            </form>
        </div>
    </div>
</x-app-layout>
