<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{

    //apply middleware for roles and permissions view order for just admin only
    public static function middleware()
    {
        return [
            new Middleware('permission:view orders', only: ['index']),
        ];
    }

    //Index function show user index
    public function index()
    {
        $orders = Order::with('user')->orderByDesc('created_at')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    //show order details
    public function show(Order $order)
    {
        $order->load('items.product', 'shipping');
        return view('admin.orders.show', compact('order'));
    }

    //order status update 
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|string']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }

   //destroy or delete order
    public function destroy($id)
{
    $order = Order::findOrFail($id);
    $order->delete();

    return redirect()->route('admin.orders')
                     ->with('success', 'Order deleted successfully.');
}
}