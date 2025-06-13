<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
    
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = $subtotal * 0.18;
        $total = $subtotal + $tax;
    
        return view('users.checkout.index', compact('cart', 'subtotal', 'tax', 'total'));
    }
    

    public function placeOrder(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'subtotal' => $request->subtotal,
            'tax' => $request->text,
            'shipping_method' => $request->shipping_method,
            'payment_method' => $request->payment_method,
            'total' => $request->total
        ]);

        foreach (session()->get('cart', []) as $productId => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('user.orders')->with('success', 'Order placed successfully!');
    }
}
