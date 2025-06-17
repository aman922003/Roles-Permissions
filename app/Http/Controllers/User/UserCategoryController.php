<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserCategoryController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return[
            new Middleware('permission:view usercategories',only: ['index']),
        ];
    }
    public function index()
    {
        $categories = Category::all();
        return view('users.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return view('users.categories.show', compact('category'));
    }
}