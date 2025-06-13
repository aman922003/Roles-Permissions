<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permissions Routes
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/list', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Roles Routes
    Route::get('/roles/list', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');


    // Article Routes
    Route::resource('articles', ArticleController::class);

    // User Routes
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes (admin prefix, admin. name, with access control)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    // ->middleware(['auth', 'can:access-admin'])
    ->group(function () {

        // Products
        Route::resource('products', ProductController::class);

        // Categories
        Route::resource('categories', CategoryController::class);
        // Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        // Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        // Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        // Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        // Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        // Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    Route::middleware(['auth'])->name('users.')->group(function () {

        // Categories
        // Route::get('/categories', [UserCategoryController::class, 'index'])->name('categories.index');
        // Route::get('/categories/{id}', [UserCategoryController::class, 'show'])->name('categories.show');
    
        // Products
        // Route::get('/products', [UserProductController::class, 'index'])->name('products.index');
        // Route::get('/categories/{id}/products', [UserProductController::class, 'showByCategory'])->name('productsByCategory');
    
        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('addToCart');
        Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
        // Checkout
        // Route::get('/checkout', [UserCheckoutController::class, 'show'])->name('checkout');
        // Route::post('/checkout', [UserCheckoutController::class, 'placeOrder'])->name('placeOrder');
    
        // Orders
        // Route::get('/orders', [UserOrderController::class, 'index'])->name('orders');
    });