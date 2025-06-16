<h1>Order #{{ $order->id }}</h1>
<p><strong>User:</strong> {{ $order->user->name }}</p>
<p><strong>Status:</strong> {{ $order->status }}</p>

<form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
    @csrf @method('PUT')
    <select name="status">
        @foreach(['pending','processing','shipped','delivered','canceled'] as $st)
        <option value="{{ $st }}" @selected($order->status==$st)>{{ ucfirst($st) }}</option>
        @endforeach
    </select>
    <button class="px-3 py-1 bg-green-500 text-white">Update Status</button>
</form>

<h2 class="mt-4">Items</h2>
<ul>
    @foreach($order->items as $item)
    <li>{{ $item->product->name }} × {{ $item->quantity }} (₹{{ $item->price }})</li>
    @endforeach
</ul>

<h2 class="mt-4">Shipping Details</h2>
<form action="{{ route('admin.shipping.update', $order->shipping) }}" method="POST">
    @csrf @method('PUT')
    @foreach(['address','city','zip','country'] as $field)
    <div>
        <label>{{ ucfirst($field) }}</label>
        <input name="{{ $field }}" value="{{ old($field, $order->shipping->{$field}) }}" required>
    </div>
    @endforeach
    <button class="px-3 py-1 bg-blue-500 text-white">Update Shipping</button>
</form>