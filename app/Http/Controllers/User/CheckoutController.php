<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\ShippingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Showing Cart using this index file calling in this function.
    public function index()
    {
        $cart = session()->get('cart', []);
    
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = $subtotal * 0.18;
        $total = $subtotal + $tax;
    
        return view('users.checkout.index', compact('cart', 'subtotal', 'tax', 'total'));
    }
    
// Place Order Functionalities


public function placeOrder(Request $request)
{
    $data = $request->validate([
        'address' => ['required', 'string', 'min:5'],
        'region' => ['required', 'string'],
        'city' => ['required', 'string'],
        'phone' => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/'],
        'country' => ['required', 'string'],
        'zip' => ['required', 'string'],
        'shipping_method' => ['required', 'string'],
        'payment_method' => ['required', 'string'],
        'subtotal' => ['required', 'numeric'],
        'tax' => ['required', 'numeric'],
        'total' => ['required', 'numeric'],
    ]);


    $order = Order::create([
        'user_id' => Auth::id(),
        'subtotal' => $data['subtotal'],
        'tax' => $data['tax'],
        'total' => $data['total'],
        'shipping_method' => $data['shipping_method'],
        'payment_method' => $data['payment_method'],
        'status' => 'pending',
    ]);

    
    ShippingDetail::create([
        'user_id' => Auth::id(),
        'order_id' => $order->id,
        'address' => $data['address'],
        'region' => $data['region'],
        'city' => $data['city'],
        'phone' => $data['phone'],
        'country' => $data['country'],
        'zip' => $data['zip'],
    ]);

    $lineItems = [];

    foreach (session('cart', []) as $productId => $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $productId,
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);

        // Fetch product from DB to get Stripe Price ID
        $product = Product::find($productId);

        if ($product && $product->stripe_price_id) {
            $lineItems[] = [
                'price' => $product->stripe_price_id,
                'quantity' => $item['quantity'],
            ];
        }
    }

    session()->forget('cart');

    // Stripe Checkout Session
    Stripe::setApiKey(config('services.stripe.secret'));

    $checkoutSession = StripeSession::create([
        'payment_method_types' => ['card'],
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => route('dashboard') . '?success=true&order_id=' . $order->id,
        'cancel_url' => route('users.checkout') . '?cancelled=true',
        'metadata' => [
            'order_id' => $order->id,
        ],
    ]);

    return redirect($checkoutSession->url);
}

}