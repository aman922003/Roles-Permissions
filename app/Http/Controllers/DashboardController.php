<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller  // implements HasMiddleware
{
     /**
     * Assign Permissions using Middleware.
     */
    // public static function middleware()
    // {
    //     return [
    //         new Middleware('permission:manage user|manage roles&permission |view product list', only: ['index']),
    //     ];
    // }

     /**
     * Redirect to dashboard blade file.
     */
    public function index() 
    {
        $products = Product::all();
        return view('dashboard',[
            'products'=> $products,
        ]);
    }
}
