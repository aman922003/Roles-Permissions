<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6 space-y-10">
        {{-- Order Tracker --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">Order Status</h3>
            @php
            $steps = ['pending', 'processing', 'shipped', 'delivered'];
            $currentStepIndex = array_search($order->status, $steps);
            @endphp

            <div class="relative flex items-center justify-between px-4 sm:px-8 pt-6 pb-2" id="order-tracker"
                data-status="{{ $order->status }}" data-current-step="{{ $currentStepIndex }}"
                data-total-steps="{{ count($steps) }}">

                {{-- Base Line --}}
                <div class="absolute top-9 left-6 right-6 h-2 bg-gray-100 z-0 rounded-full"></div>

                {{-- Progress Line --}}
                <div id="progress-line"
                    class="absolute top-9 left-6 h-2 z-10 rounded-full bg-green-500 transition-all duration-500 ease-out"
                    style="width: 0%;">
                </div>

                {{-- Steps --}}
                @foreach($steps as $index => $step)
                <div class="relative z-20 flex flex-col items-center text-center w-1/4">
                    <div class="step-circle w-12 h-12 flex items-center justify-center rounded-full border-4 bg-white transition-all duration-500 ease-in-out"
                        data-step-index="{{ $index }}" style="border-color: #10b981;">
                        <div
                            class="check-icon hidden w-6 h-6 rounded-full bg-green-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <span class="mt-3 text-sm font-medium step-label transition-all duration-300 text-gray-500">
                        {{ ucfirst($step) }}
                    </span>
                    <span class="status-info text-xs mt-1 text-gray-400 hidden">Completed</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Ordered Items --}}
        <div class="bg-white shadow rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Ordered Items</h3>
            <ul class="divide-y divide-kgray-200">
                @foreach($order->items as $item)
                <li class="py-3 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-md object-cover"
                                src="{{ $item->product->image_url ?? 'https://via.placeholder.com/150' }}"
                                alt="{{ $item->product->name }}">
                        </div>
                        <div>
                            <span class="text-gray-700">{{ $item->product->name }}</span>
                            <span class="block text-xs text-gray-500">Qty: {{ $item->quantity }}</span>
                        </div>
                    </div>
                    <span class="text-gray-900 font-semibold">₹{{ number_format($item->price, 2) }}</span>
                </li>
                @endforeach
            </ul>
            <div class="pt-4 border-t mt-4">
                <div class="flex justify-between text-gray-700 mb-2">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-700 mb-2">
                    <span>Shipping</span>
                    <span>₹{{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-700 mb-2">
                    <span>Tax</span>
                    <span>₹{{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-800 mt-3 pt-3 border-t">
                    <span>Total</span>
                    <span>₹{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping Details --}}
        <div class="bg-white shadow rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Shipping Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                <div>
                    <span class="font-medium block text-gray-500 text-sm">Name</span>
                    <p class="mt-1">{{ $order->user->name }}</p>
                </div>
                <div>
                    <span class="font-medium block text-gray-500 text-sm">Phone</span>
                    <p class="mt-1">{{ $order->shipping->phone }}</p>
                </div>
                <div class="md:col-span-2">
                    <span class="font-medium block text-gray-500 text-sm">Address</span>
                    <p class="mt-1">{{ $order->shipping->address }}</p>
                </div>
                <div>
                    <span class="font-medium block text-gray-500 text-sm">Region</span>
                    <p class="mt-1">{{ $order->shipping->region }}</p>
                </div>
                <div>
                    <span class="font-medium block text-gray-500 text-sm">City</span>
                    <p class="mt-1">{{ $order->shipping->city }}</p>
                </div>
                <div>
                    <span class="font-medium block text-gray-500 text-sm">Country</span>
                    <p class="mt-1">{{ $order->shipping->country }}</p>
                </div>
                <div>
                    <span class="font-medium block text-gray-500 text-sm">Zip Code</span>
                    <p class="mt-1">{{ $order->shipping->zip }}</p>
                </div>
            </div>
        </div>

        {{-- Order Actions --}}
        @if($order->status !== 'cancelled' && $order->status !== 'delivered')
        <div class="bg-white shadow rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Order Actions</h3>
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                @if($order->status === 'pending')
                <form method="POST" action="#">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md transition">
                        Cancel Order
                    </button>
                </form>
                @endif
                <a href="{{ route('users.orders.index') }}"
                    class="px-4 py-2 border border-gray-300 hover:bg-gray-50 rounded-md transition text-center">
                    Back to My Orders
                </a>
            </div>
        </div>
        @endif
    </div>

    <style>
    @keyframes pop-in {
        0% {
            transform: scale(0);
        }

        80% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    .animate-pop-in {
        animation: pop-in 0.5s forwards;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .animate-pulse {
        animation: pulse 0.6s ease-in-out;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const tracker = document.getElementById('order-tracker');
        const totalSteps = parseInt(tracker.dataset.totalSteps);
        const currentStep = parseInt(tracker.dataset.currentStep);
        const progressLine = document.getElementById('progress-line');

        const animateStep = (step = 0) => {
            if (step > currentStep) return;

            const percent = (step / (totalSteps - 1)) * 100;
            progressLine.style.width = percent + '%';

            const stepCircle = document.querySelector(`.step-circle[data-step-index="${step}"]`);
            const checkIcon = stepCircle.querySelector('.check-icon');
            const label = stepCircle.nextElementSibling;
            const statusInfo = stepCircle.parentElement.querySelector('.status-info');

            stepCircle.style.borderColor = '#10b981';
            stepCircle.classList.add('animate-pulse');

            setTimeout(() => {
                checkIcon.classList.remove('hidden');
                label.classList.remove('text-gray-500');
                label.classList.add('text-green-600');
                statusInfo.textContent = step === currentStep ? 'Current' : 'Completed';
                statusInfo.classList.remove('hidden');

                animateStep(step + 1);
            }, 600);
        };

        setTimeout(() => {
            animateStep(0);
        }, 300);
    });
    </script>
</x-app-layout>