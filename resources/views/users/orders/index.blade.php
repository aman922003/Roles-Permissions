<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">My Orders</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">
        @if($orders->count())
            <div class="bg-white shadow border border-gray-200 rounded-xl overflow-x-auto">
                <table class="w-full table-auto text-left text-sm">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-3">Order ID</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y divide-gray-200">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-4 py-3">#{{ $order->id }}</td>
                                <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 capitalize">{{ $order->status }}</td>
                                <td class="px-4 py-3">₹{{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('users.orders.show', $order) }}"
                                        class="text-blue-600 hover:underline font-medium">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-gray-600 bg-white border border-gray-200 p-6 rounded-xl shadow text-center">
                You have not placed any orders yet.
            </div>
        @endif
    </div>
</x-app-layout>
