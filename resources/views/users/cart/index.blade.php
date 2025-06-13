<h2 class="text-2xl font-semibold mb-4">Your Cart</h2>

@if(session('cart'))
<table class="w-full table-auto border">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-2">Product</th>
            <th class="p-2">Quantity</th>
            <th class="p-2">Price</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach(session('cart') as $product)
        @php $total += $product['price'] * $product['quantity']; @endphp
        <tr>
            <td class="p-2">{{ $product['name'] }}</td>
            <td class="p-2">{{ $product['quantity'] }}</td>
            <td class="p-2">₹{{ $product['price'] }}</td>
        </tr>
        @endforeach
        <tr class="font-bold">
            <td class="p-2">Total</td>
            <td></td>
            <td class="p-2">₹{{ $total }}</td>
        </tr>
    </tbody>
</table>
<div class="mt-4">
    <a href="{{ route('user.checkout') }}" class="bg-green-600 text-white px-4 py-2 rounded">Checkout</a>
</div>
@else
<p>Your cart is empty.</p>
@endif