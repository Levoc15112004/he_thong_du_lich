<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttrController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\CategoryController;
// use App\Http\Controllers\Admin\ChatbotController;
use App\Http\Controllers\Admin\ChatmessageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TourScheduleController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\UserVoucherController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\BillController;
use App\Http\Controllers\User\BlogController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ChatbotController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\MomoController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use App\Http\Controllers\User\PayPalController;
use App\Http\Controllers\User\ReviewController as UserReviewController;
use App\Http\Controllers\User\TourBookedController;
use App\Http\Controllers\User\TourDetailController;
use App\Http\Controllers\User\WeatherController;
use App\Http\Controllers\User\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login-admin', [AdminController::class, 'login'])->name('login.admin');
Route::post('login-admin', [AdminController::class, 'postLogin'])->name('postLogin.admin');
Route::get('logout-admin', [AdminController::class, 'logout'])->name('logout.admin');

Route::middleware('checkAdmin')->prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'home'])->name('admin.home');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');

    Route::get('attrs', [AttrController::class, 'index'])->name('admin.attr.index');
    Route::get('attrs/create', [AttrController::class, 'create'])->name('admin.attr.create');
    Route::post('attrs', [AttrController::class, 'store'])->name('admin.attr.store');
    Route::get('attrs/{id}/edit', [AttrController::class, 'edit'])->name('admin.attr.edit');
    Route::put('attrs/{id}', [AttrController::class, 'update'])->name('admin.attr.update');
    Route::delete('attrs/{id}', [AttrController::class, 'destroy'])->name('admin.attr.destroy');

    Route::get('users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [UsersController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::get('users/edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{id}', [UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('tours', [TourController::class, 'index'])->name('admin.tours.index');
    Route::get('tours/create', [TourController::class, 'create'])->name('admin.tours.create');
    Route::post('tours', [TourController::class, 'store'])->name('admin.tours.store');
    Route::get('tours/edit/{id}', [TourController::class, 'edit'])->name('admin.tours.edit');
    Route::put('tours/{id}', [TourController::class, 'update'])->name('admin.tours.update');
    Route::delete('tours/{id}', [TourController::class, 'destroy'])->name('admin.tours.destroy');
    Route::post('tours/seed-sample', [TourController::class, 'seedSample'])->name('admin.tours.seed');


    Route::get('tour-schedules', [TourScheduleController::class, 'index'])->name('admin.tour_schedules.index');
    Route::get('tour-schedules/create', [TourScheduleController::class, 'create'])->name('admin.tour_schedules.create');
    Route::post('tour-schedules', [TourScheduleController::class, 'store'])->name('admin.tour_schedules.store');
    Route::get('tour-schedules/edit/{id}', [TourScheduleController::class, 'edit'])->name('admin.tour_schedules.edit');
    Route::put('tour-schedules/{id}', [TourScheduleController::class, 'update'])->name('admin.tour_schedules.update');
    Route::delete('tour-schedules/{id}', [TourScheduleController::class, 'destroy'])->name('admin.tour_schedules.destroy');

    Route::get('banners', [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('banners/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Route::post('banners', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::get('banners/edit/{id}', [BannerController::class, 'edit'])->name('admin.banners.edit');
    Route::put('banners/{id}', [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('banners/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');

    Route::get('payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('payments/{id}', [PaymentController::class, 'show'])->name('admin.payments.show');
    Route::put('payments/update-status/{id}', [PaymentController::class, 'updateStatus'])->name('admin.payments.updateStatus');
    Route::delete('payments/{id}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');

    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

    Route::get('vouchers', [VoucherController::class, 'index'])->name('admin.vouchers.index');
    Route::get('vouchers/create', [VoucherController::class, 'create'])->name('admin.vouchers.create');
    Route::post('vouchers', [VoucherController::class, 'store'])->name('admin.vouchers.store');
    Route::get('vouchers/edit/{id}', [VoucherController::class, 'edit'])->name('admin.vouchers.edit');
    Route::put('vouchers/{id}', [VoucherController::class, 'update'])->name('admin.vouchers.update');
    Route::delete('vouchers/{id}', [VoucherController::class, 'destroy'])->name('admin.vouchers.destroy');

    Route::get('user-voucher', [UserVoucherController::class, 'index'])->name('admin.user_vouchers.index');
    Route::get('user-voucher/create', [UserVoucherController::class, 'create'])->name('admin.user_vouchers.create');
    Route::post('user-voucher', [UserVoucherController::class, 'store'])->name('admin.user_vouchers.store');
    Route::get('user-voucher/{id}/edit', [UserVoucherController::class, 'edit'])->name('admin.user_vouchers.edit');
    Route::put('user-voucher/{id}', [UserVoucherController::class, 'update'])->name('admin.user_vouchers.update');
    Route::delete('user-voucher/{id}', [UserVoucherController::class, 'destroy'])->name('admin.user_vouchers.destroy');
    Route::post('/admin/user-vouchers/assign-random-users', [UserVoucherController::class, 'assignRandomUsers'])->name('admin.user_vouchers.assign_random_users');

    Route::get('reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('reviews/{id}', [ReviewController::class, 'show'])->name('admin.reviews.show');
    Route::put('reviews/{id}', [ReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    Route::get('blogs', [BlogsController::class, 'index'])->name('admin.blogs.index');
    Route::get('blogs/create', [BlogsController::class, 'create'])->name('admin.blogs.create');
    Route::post('blogs', [BlogsController::class, 'store'])->name('admin.blogs.store');
    Route::get('blogs/edit/{id}', [BlogsController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('blogs/{id}', [BlogsController::class, 'update'])->name('admin.blogs.update');
    Route::delete('blogs/{id}', [BlogsController::class, 'destroy'])->name('admin.blogs.destroy');
    Route::post('/upload-image', [BlogsController::class, 'uploadImage'])->name('admin.upload.image');

    Route::get('payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('payments/{id}', [PaymentController::class, 'show'])->name('admin.payments.show');
    Route::put('payments/updates/{id}', [PaymentController::class, 'updateStatus'])->name('admin.payments.updateStatus');
    Route::delete('payments/{id}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');

    Route::get('chats', [ChatmessageController::class, 'index'])->name('admin.chat.index');
    Route::get('chats/show/{id}', [ChatmessageController::class, 'show'])->name('admin.chat.show');
    Route::post('/chat/{sessionId}/send', [ChatmessageController::class, 'sendMessage'])->name('admin.chat.send');
    Route::post('/chat/{id}/end', [ChatmessageController::class, 'endSession'])->name('admin.chat.end');
    Route::delete('/chat/{id}', [ChatmessageController::class, 'destroy'])->name('admin.chat.destroy');

    Route::get('/reports', [StatisticController::class, 'index'])->name('admin.reports');
});


Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('user.home');
    Route::get('/tours', [HomeController::class, 'allTours'])->name('user.tours');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::post('/tu-van', [HomeController::class, 'sendConsultation'])->name('consultation.send');
    Route::post('/contact/send', [HomeController::class, 'sendConsultation'])->name('contact.send');

    // Route::get('/chat/history', [ChatbotController::class, 'history']);

    // Route::post('/api/chat', [ChatbotController::class, 'generateContent'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    // Route::get('/api/chat/history', [ChatbotController::class, 'history'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    // Route::post('/chat', [ChatController::class, 'chat']);

    Route::get('/search', [HomeController::class, 'search'])->name('user.search');
    Route::post('/search', [HomeController::class, 'searchHome'])->name('user.home.search');
    Route::get('/search/default', [HomeController::class, 'default'])->name('user.search.default');
    Route::get('/category/{id}', [HomeController::class, 'TourCate'])->name('user.category');
    Route::get('/destination/{location}', [HomeController::class, 'destination'])->name('user.destination');
    // Route::get('/blog/{id}', [HomeController::class, 'blogs'])->name('user.blogs');
    Route::get('/weather/ajax', [WeatherController::class, 'searchAjax'])->name('weather.ajax');

    Route::get('/account', [AccountController::class, 'account'])->name('account');
    Route::post('/login', [AccountController::class, 'login'])->name('user.login');
    Route::post('/register', [AccountController::class, 'register'])->name('user.register');
    Route::post('/logout', [AccountController::class, 'logout'])->name('user.logout');

    Route::get('/forgot-password', [AccountController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [AccountController::class, 'sendOtp'])->name('password.email');
    Route::get('/reset-password', [AccountController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AccountController::class, 'resetPassword'])->name('password.update');

    Route::get('/tour-detail/{id}', [TourDetailController::class, 'index'])->name('user.tourDetail.index');
    Route::get('/tour/schedule/{id}/json', [TourDetailController::class, 'getScheduleByTour']);

    // SEO / GEO / CRAWLER
    Route::get('/sitemap.xml', [SitemapController::class, 'sitemap'])->name('seo.sitemap');
    Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('seo.robots');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::middleware('checkUser')->group(function () {

    Route::get('/user', [AccountController::class, 'user'])->name('user');
    Route::post('/user/change-password', [AccountController::class, 'update'])->name('user.change.password');
    Route::get('/thong-bao/{id}/read', [HomeController::class, 'markAsRead'])->name('user.notifications.read');

    Route::get('/order', [UserOrderController::class, 'order'])->name('user.order.index');
    Route::post('/order/store', [UserOrderController::class, 'addOrder'])->name('user.order.store');

    Route::get('/order/thanh-toan-coc/{order_id}', [BookingController::class, 'showDepositPage'])->name('user.tour.deposit');
    Route::post('/tour/deposit/pay', [BookingController::class, 'processPayment'])->name('user.tour.deposit.pay');
    Route::get('/payment/final/{order_id}', [BookingController::class, 'showFinalPaymentPage'])->name('user.payment.final');

    Route::post('/paypal/create-order/{order_id}', [PayPalController::class, 'createPayment'])->name('paypal.create');
    // Capture thanh toán 30%
    Route::post('/paypal/capture', [PayPalController::class, 'capture'])->name('paypal.capture');
    // Tạo PayPal Order cho 70%
    Route::post('/paypal/create-final-order/{order_id}', [PayPalController::class, 'createFinalPayment'])->name('paypal.createFinal');
    // Capture thanh toán 70%
    Route::post('/paypal/capture-final', [PayPalController::class, 'captureFinal'])->name('paypal.captureFinal');

    Route::get('/my-tours', [TourBookedController::class, 'myBookedTours'])->name('user.tours.booked');
    Route::get('/booked-tours', [TourBookedController::class, 'myBookedTours'])->name('tourBooked');
    Route::get('/my-tours/schedule/{order_id}', [TourBookedController::class, 'showSchedule'])->name('my-tour.schedules');
    Route::get('/my-tours/schedule/{order_id}/json', [TourBookedController::class, 'getScheduleData'])->name('my-tour.schedules.json');

    Route::get('user/tour/review/{orderId}', [UserReviewController::class, 'create'])->name('review.create');
    Route::post('user/review/store', [UserReviewController::class, 'store'])->name('review.store');

    Route::get('/user/profile/{id}', [HomeController::class, 'profile'])->name('user.profile');
    Route::post('/user/update-profile', [HomeController::class, 'updateProfile'])->name('user.updateProfile');

    Route::get('/user/bill/export/{order_id}', [BillController::class, 'export'])->name('user.bill.export');

});

Route::get('/cart', [CartController::class, 'Cart'])->name('user.cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('user.cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('user.cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'delete'])->name('user.cart.remove');
Route::get('/cart/remove/{id}', [CartController::class, 'delete']);
Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('user.cart.applyVoucher');

Route::post('/payment', [UserPaymentController::class, 'payment'])->name('user.payment');
Route::get('/payment/thanks/{order_id}', [UserPaymentController::class, 'thankYou'])->name('tour.thankyou');
Route::get('/payment/final/thanks/{order_id}', [UserPaymentController::class, 'thankYouFinal'])->name('tour.thankyou.final');
Route::post('/order/cancel/{order}', [UserPaymentController::class, 'cancelOrder'])->name('order.cancel');

// thanh toán momo
Route::post('/payment/momo/deposit/{order}', [MomoController::class, 'createDeposit'])->name('momo.deposit');
Route::post('/payment/momo/final/{order}', [MomoController::class, 'createFinal'])->name('momo.final');
// Route::get('/momo/ipn', [MomoController::class, 'ipn'])->name('momo.ipn');
Route::post('/momo/ipn', [MomoController::class, 'ipn'])->name('momo.ipn');
Route::get('/momo/return', [MomoController::class, 'return'])->name('momo.return');

Route::match(['get', 'post'], '/chat', [ChatbotController::class, 'chat'])->name('chatbot.chat');
Route::post('/api/chat', [ChatbotController::class, 'chat'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/chat-stream', [ChatbotController::class, 'chatStream']);
Route::get('/chat/history', [ChatbotController::class, 'history']);
Route::get('/api/chat/history', [ChatbotController::class, 'history'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);