<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\UserCategoryController;
use App\Http\Controllers\User\UserProductController;
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
    ->group(function () {
        // Products
        Route::resource('products', ProductController::class);
        // Categories
        Route::resource('categories', CategoryController::class);
         // Orders

         Route::get('/orders', [OrderController::class, 'index'])->name('orders');
         Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

          // Update Order Status
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->name('orders.delete');

        // Shipping Details
        Route::put('shipping/{shippingDetail}', [ShippingController::class, 'updateDetails'])->name('shipping.update');


    });

    Route::middleware(['auth'])->name('users.')->group(function () {

         // Categories
    Route::get('/categories', [UserCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{id}', [UserCategoryController::class, 'show'])->name('categories.show');

    // Products
    Route::get('/products', [UserProductController::class, 'index'])->name('products.index');
    Route::get('/categories/{id}/products', [UserProductController::class, 'showByCategory'])->name('productsByCategory');

        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('addToCart');
        Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
        // Checkout
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('placeorder');
    
    });