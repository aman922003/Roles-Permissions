<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6 space-y-10">

        {{-- Order Summary --}}
        <div class="bg-white shadow rounded-2xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Order Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 text-base">
                <p><span class="font-medium">User:</span> {{ $order->user->name }}</p>
                <p><span class="font-medium">Status:</span> {{ ucfirst($order->status) }}</p>
            </div>
        </div>

        {{-- Update Order Status --}}
        <div class="bg-white shadow rounded-2xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Update Order Status</h3>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                class="flex flex-col sm:flex-row sm:items-center gap-4">
                @csrf @method('PUT')
                <select name="status"
                    class="px-4 py-2 w-full sm:w-auto border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    @foreach(['pending','processing','shipped','delivered','canceled'] as $st)
                    <option value="{{ $st }}" @selected($order->status==$st)>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-md shadow-md transition">
                    Update Status
                </button>
            </form>
        </div>

        {{-- Ordered Items --}}
        <div class="bg-white shadow rounded-2xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Ordered Items</h3>
            <div class="bg-gray-50 border rounded-lg p-4">
                <ul class="divide-y divide-gray-200 text-gray-700">
                    @foreach($order->items as $item)
                    <li class="py-3 flex justify-between items-center">
                        <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                        <span class="font-semibold text-gray-900">₹{{ number_format($item->price, 2) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Shipping Details --}}
        <div class="bg-white shadow rounded-2xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">Shipping Details</h3>
            <form action="{{ route('admin.shipping.update', $order->shipping) }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf @method('PUT')
                @foreach(['address','region','city','phone','country','zip'] as $field)
                <div>
                    <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ ucfirst($field) }}
                    </label>
                    <input id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $order->shipping->{$field}) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
                </div>
                @endforeach
                <div class="md:col-span-2 text-right pt-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md shadow-md transition">
                        Update Shipping
                    </button>
                </div>
            </form>
        </div>

    </div>
    <script src="{{ asset('js/ecommerce-validation.js') }}"></script>
</x-app-layout>