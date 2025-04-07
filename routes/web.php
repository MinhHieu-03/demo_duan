<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentController;


//HomeController
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', [CategoryController::class, 'showDiscountedProducts'])->name('home');
Route::get('/load-more', [CategoryController::class, 'loadMore']);



//CategoryController
Route::get('/', [CategoryController::class, 'showDiscountedProducts'])->name('home');
Route::get('/laptop-giam-gia', [CategoryController::class, 'showDiscountedProducts'])->name('categories.discounted');
Route::get('/discounted-products', [CategoryController::class, 'showDiscountedProducts'])->name('discounted-products');
Route::get('/search', [CategoryController::class, 'search'])->name('search');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::group(['middleware' => 'admin'], function () {
    //Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
});
Route::resource('categories', CategoryController::class);
Route::get('/category/{name}', [CategoryController::class, 'filterByCategory'])->name('category.filter');
Route::get('/orders/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('order.cancel');
Route::get('/gioi-thieu-laptop', function () {
    return view('laptop.introduction');
})->name('laptop.introduction');
//Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::resource('categories', CategoryController::class)->except(['show']);



//AuthController
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');




//CartController
Route::post('/cart/add/{category:slug}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.process');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add')->middleware('auth');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');




//UserController
Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
Route::put('/user/update-password', [UserController::class, 'updatePassword'])->name('user.update.password');



//AdminController
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/categories', [AdminController::class, 'showCategories'])->name('categories');
    Route::get('/orders', [AdminController::class, 'showOrders'])->name('orders');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout'); // Sửa lại route này
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

});
Route::get('/admin/categories', [AdminController::class, 'showCategories'])->name('admin.categories');
Route::get('/admin/orders', [AdminController::class, 'showOrders'])->name('admin.orders');
Route::get('/admin/revenue-report', [App\Http\Controllers\AdminController::class, 'revenueReport'])->name('admin.revenueReport');
Route::get('/admin/order-details/{buyerName}', [AdminController::class, 'orderDetails'])->name('admin.orderDetails');



//OrderController
//AdminOrderController
Route::get('/orders/success', [OrderController::class, 'orderSuccess'])->name('orders.success');
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.order');
    Route::get('/orders', [OrderController::class, 'showOrders'])->name('orders.index');
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::post('orders/{id}/approve', [AdminOrderController::class, 'approve'])->name('admin.orders.approve');
    Route::post('orders/{id}/reject', [AdminOrderController::class, 'reject'])->name('admin.orders.reject');
    
});
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');



//UserOrderController
Route::get('/my-orders', [UserOrderController::class, 'index'])->name('my.orders')->middleware('auth');
Route::get('/my-orders/{id}', [UserOrderController::class, 'show'])->name('orders.show')->middleware('auth');
Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');




//CommnentController
Route::post('comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
Route::middleware(['auth'])->group(function () {
    Route::post('/categories/{category:slug}/comments', [CommentController::class, 'store'])->name('comments.store');
});
Route::get('/admin/comments', [CommentController::class, 'index'])->name('admin.comments.index');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');


//NotificationController
Route::get('/notifications/{id}', [NotificationController::class, 'read'])->name('notifications.read');
Route::get('/notifications/{id}', [NotificationController::class, 'read'])->name('notifications.read');
Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');



//MessageController
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'adminIndex'])->name('admin.messages.index');
    Route::get('/admin/messages', [MessageController::class, 'adminIndex'])->name('admin.messages.index');
    Route::post('/admin/messages/reply', [MessageController::class, 'reply'])->name('messages.reply');
});



//InvoiceController
Route::get('/orders/{id}/invoice', [InvoiceController::class, 'generateInvoice'])->name('orders.invoice');



//ReportController
Route::get('/admin/revenue-report', [ReportController::class, 'revenueReport'])->name('admin.revenueReport');
Route::get('/admin/revenue-report/pdf', [ReportController::class, 'printRevenueReport'])->name('admin.printRevenueReport');



//PaymentController

Route::post('/vnpay_payment', [PaymentController::class, 'vnpay_payment']);
Route::get('/vnpay/return', [PaymentController::class, 'vnpay_return'])->name('vnpay.return');

Route::get('/orders/success', function () {
    return view('orders.success');
})->name('orders.success');
Route::get('/orders', function () {
    return view('orders.index'); // Trang danh sách đơn hàng
})->name('orders.index');
