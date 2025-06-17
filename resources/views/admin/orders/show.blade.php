<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6 space-y-8 bg-white shadow-md rounded-lg mt-6">
        
        {{-- Order Summary --}}
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Order Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-800">
                <p><strong>User:</strong> {{ $order->user->name }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
        </div>

        {{-- Update Order Status --}}
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Update Order Status</h3>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-4">
                @csrf @method('PUT')
                <select name="status" class="px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    @foreach(['pending','processing','shipped','delivered','canceled'] as $st)
                        <option value="{{ $st }}" @selected($order->status==$st)>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow transition">
                    Update Status
                </button>
            </form>
        </div>

        {{-- Order Items --}}
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Ordered Items</h3>
            <div class="border rounded-md p-4 bg-gray-50">
                <ul class="space-y-2 text-gray-800">
                    @foreach($order->items as $item)
                        <li class="flex justify-between">
                            <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                            <span class="text-right font-semibold">₹{{ $item->price }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Shipping Details --}}
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Shipping Details</h3>
            <form action="{{ route('admin.shipping.update', $order->shipping) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf @method('PUT')
                @foreach(['address','region','city','phone','country','zip'] as $field)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst($field) }}</label>
                        <input name="{{ $field }}" value="{{ old($field, $order->shipping->{$field}) }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" />
                    </div>
                @endforeach
                <div class="md:col-span-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md shadow transition">
                        Update Shipping
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
