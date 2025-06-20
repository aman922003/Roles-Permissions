<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stripe\Stripe;
use Stripe\Product as StripeProduct;
use Stripe\Price as StripePrice;

class ProductController extends Controller
{
    //product index show 
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    //create products
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    //store products in databse
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Create product on Stripe
        $stripeProduct = StripeProduct::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'images' => [asset('storage/' . $validated['image'])],
            'default_price_data' => [
                'unit_amount' => $validated['price'] * 100, 
                'currency' => 'inr',
            ],
            'expand' => ['default_price'],
        ]); 

        // Save Stripe product ID in your DB (you may want to add a column for it)
        $validated['stripe_product_id'] = $stripeProduct->id;
        $validated['stripe_price_id'] = $stripeProduct->default_price->id;

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created and added to Stripe catalog.');
    }

    //edit admin products
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    //upadate admin products
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    
        // Handle image
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
    
        try {

            if ($product->stripe_product_id) {
                Stripe::setApiKey(config('services.stripe.secret'));
    
                // 1. Update product name & description
                StripeProduct::update($product->stripe_product_id, [
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                ]);
    
                // 2. Create new price
                $newPrice = StripePrice::create([
                    'product' => $product->stripe_product_id,
                    'unit_amount' => $validated['price'] * 100, // INR in paisa
                    'currency' => 'inr',
                ]);
    
                // 3. Set as default price
                StripeProduct::update($product->stripe_product_id, [
                    'default_price' => $newPrice->id,
                ]);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Stripe update failed: ' . $e->getMessage());
        }
    
        $product->update($validated);
    
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated in Laravel and Stripe.');
    }
    

    //admin destroy products
    public function destroy(Product $product)
    {
        // Delete local image
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        try {
            if ($product->stripe_product_id) {
                Stripe::setApiKey(config('services.stripe.secret'));

                // Stripe doesn't allow full deletion → archive instead
                StripeProduct::update($product->stripe_product_id, [
                    'active' => false,
                ]);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Stripe archive failed: ' . $e->getMessage());
        }

        $product->delete();

        return back()->with('success', 'Product deleted from Laravel and archived in Stripe.');
    }

}




