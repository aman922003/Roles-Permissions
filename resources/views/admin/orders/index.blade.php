<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Orders') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-gray-800">
                        @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4">{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 capitalize">{{ $order->status }}</td>
                            <td class="px-6 py-4">₹{{ $order->total }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex space-x-2">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md shadow transition">
                                        View
                                    </a>

                                    <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this order?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-md shadow transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="my-4 px-6">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>