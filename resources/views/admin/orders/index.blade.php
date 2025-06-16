<h1>Orders</h1>
<table class="border w-full">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Status</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $ord)
            <tr>
                <td>
                    {{ $ord->id }}
                </td>
                <td>
                    {{ $ord->user->name }}
                </td>
                <td>
                    {{ $ord->status }}
                </td>
                <td>₹
                    {{ $ord->total }}
                </td>
                <td><a href="{{ route('admin.orders.show', $ord) }}">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>