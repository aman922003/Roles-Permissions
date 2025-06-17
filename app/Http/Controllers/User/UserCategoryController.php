<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserCategoryController extends Controller implements HasMiddleware
{
    //middleware for roles and permissions
    public static function middleware()
    {
        return[
            new Middleware('permission:view usercategories',only: ['index']),
        ];
    }

    //show user category index file
    public function index()
    {
        $categories = Category::all();
        return view('users.categories.index', compact('categories'));
    }

    //show user categories
    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return view('users.categories.show', compact('category'));
    }
}