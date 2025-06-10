<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
     /**
     * Assign Permissions using Middleware.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:manage user|manage roles&permission', only: ['index']),
        ];
    }

     /**
     * Redirect to dashboard blade file.
     */
    public function index()
    {
        return view('dashboard');
    }
}
