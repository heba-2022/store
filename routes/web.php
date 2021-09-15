<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController As pcB;
use App\Http\Controllers\Front\ProductsController As pcF;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Payments\PayPalController;

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

//pcF -> ProductsController for front pages
Route::get('/', [pcF::class, 'index'])->name('home');
Route::get('/home2', [pcF::class, 'index2'])->name('home2');
Route::get('product-detail/{slug}', [pcF::class, 'show'])->name('show');
Route::post('reviews', [pcF::class, 'review'])->name('review');


Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('cart', [CartController::class, 'store']);


Route::get('/checkout', [CheckoutController::class,'create'])->name('checkout');
Route::post('/checkout', [CheckoutController::class,'store']);



//Route::get('/pd', [pc::class, 'index']);



Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
});


Route::resource('categories',CategoriesController::class);
//Route::get('categories/{id}', [CategoriesController::class, 'show'])->name('show');

//pcF -> ProductsController for dashboard pages
Route::resource('products',pcB::class);


// Route::get('/dashboard',[ DashboardController::class,'index'])->name('dashboard')
// ->middleware('auth');





////////////////////////////
//بوابات االدفع 
//modile binding على مستوى الراوت -. الارففل لحالها رح تعمل فاين اور فيل  وحيضلو نفسو اي دي
//لو ماكان الاسم نفس بعض رح يرجعلي الاي دي وانا ارجع المودل
Route::get('/payments/paypal/{order}', [PayPalController::class, 'create'])->name('payments.paypal');
Route::get('/payments/paypal/{order}/return', [PayPalController::class, 'callback'])->name('paypal.return');
Route::get('/payments/paypal/{order}/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');
