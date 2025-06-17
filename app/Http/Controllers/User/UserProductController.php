<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class UserProductController extends Controller
{

    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('user.products.index', compact('products'));
    }

    public function showByCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(10);
        return view('users.products.by_category', compact('products', 'category'));
    }
}
