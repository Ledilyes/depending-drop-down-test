<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\PostController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\UserProduct;





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



Auth::routes(['register'=>false]);

Route::get('user/login',[FrontendController::class,'login'])->name('login.form');
Route::post('user/login',[FrontendController::class,'loginSubmit'])->name('login.submit');
Route::get('user/logout',[FrontendController::class,'logout'])->name('user.logout');

Route::get('user/register',[FrontendController::class,'register'])->name('register.form');
Route::post('user/register',[FrontendController::class,'registerSubmit'])->name('register.submit');
// Reset password
Route::get('password/old-reset', [FrontendController::class,'showResetForm'])->name('passwords.old-reset'); 
// Socialite 
Route::get('login/{provider}/', [LoginController::class,'redirect'])->name('login.redirect');
Route::get('login/{provider}/callback/', [LoginController::class,'Callback'])->name('login.callback');

Route::get('/',[FrontendController::class,'home'])->name('home');

// Frontend Routes
  // Ajax for CITY
    Route::post('/userproduct/{id}/cities',[FrontendController::class,'getcitydByParent']);
   // Route::post('getcity',[FrontendController::class,'getcity'])->name('state');
     


Route::get('/home', [FrontendController::class,'index']);
Route::get('/about-us',[FrontendController::class,'aboutUs'])->name('about-us');
Route::get('/contact',[FrontendController::class,'contact'])->name('contact');
Route::post('/contact/message',[MessageController::class,'store'])->name('contact.store');
Route::get('product-detail/{slug}',[FrontendController::class,'productDetail'])->name('product-detail');
Route::any('/product/search',[FrontendController::class,'productSearch'])->name('product.search');
Route::get('/product-cat/{slug}',[FrontendController::class,'productCat'])->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}',[FrontendController::class,'productSubCat'])->name('product-sub-cat');
Route::get('/product-brand/{slug}',[FrontendController::class,'productBrand'])->name('product-brand');
// Cart section
Route::get('/add-to-cart/{slug}',[CartController::class,'addToCart'])->name('add-to-cart')->middleware('user');
Route::post('/add-to-cart',[CartController::class,'singleAddToCart'])->name('single-add-to-cart')->middleware('user');
Route::get('cart-delete/{id}',[CartController::class,'cartDelete'])->name('cart-delete');
Route::post('cart-update',[CartController::class,'cartUpdate'])->name('cart.update');

Route::get('/cart',function(){
    return view('frontend.pages.cart');
})->name('cart');
Route::get('/checkout',[CartController::class,'checkout'])->name('checkout')->middleware('user');
// Wishlist
Route::get('/wishlist',function(){
    return view('frontend.pages.wishlist');
})->name('wishlist');
Route::get('/wishlist/{slug}',[WishlistController::class,'wishlist'])->name('add-to-wishlist')->middleware('user');
Route::get('wishlist-delete/{id}',[WishlistController::class,'wishlistDelete'])->name('wishlist-delete');
Route::post('cart/order',[OrderController::class,'store'])->name('cart.order');
Route::get('order/pdf/{id}',[OrderController::class,'pdf'])->name('order.pdf');
Route::get('/income',[OrderController::class,'incomeChart'])->name('product.order.income');
 Route::get('/user/chart','AdminController@userPieChart')->name('user.piechart');
Route::get('/product-grids',[FrontendController::class,'productGrids'])->name('product-grids');
Route::get('/product-lists',[FrontendController::class,'productLists'])->name('product-lists');
Route::match(['get','post'],'/filter',[FrontendController::class,'productFilter'])->name('shop.filter');
// Order Track
Route::get('/product/track',[OrderController::class,'orderTrack'])->name('order.track');
Route::post('product/track/order',[OrderController::class,'productTrackOrder'])->name('product.track.order');
// Blog
Route::get('/blog',[FrontendController::class,'blog'])->name('blog');
Route::get('/blog-detail/{slug}',[FrontendController::class,'blogDetail'])->name('blog.detail');
Route::get('/blog/search',[FrontendController::class,'blogSearch'])->name('blog.search');
Route::post('/blog/filter',[FrontendController::class,'blogFilter'])->name('blog.filter');
Route::get('blog-cat/{slug}',[FrontendController::class,'blogByCategory'])->name('blog.category');
Route::get('blog-tag/{slug}',[FrontendController::class,'blogByTag'])->name('blog.tag');

// NewsLetter
Route::post('/subscribe',[FrontendController::class,'subscribe'])->name('subscribe');

// Product Review
Route::resource('/review',ProductReviewController::class);
Route::post('product/{slug}/review',[ProductReviewController::class,'store'])->name('review.store');

// Post Comment 
Route::post('post/{slug}/comment',[PostCommentController::class,'store'])->name('post-comment.store');
Route::resource('/comment',PostCommentController::class);
 //Coupon
Route::post('/coupon-store',[CouponController::class,'couponStore'])->name('coupon-store');
 //Payment
Route::get('payment', [PayPalController::class,'payment'])->name('payment');
Route::get('cancel', [PayPalController::class,'cancel'])->name('payment.cancel');
Route::get('payment/success', [PayPalController::class,'success'])->name('payment.success');



// Backend section start













Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
   \UniSharp\LaravelFilemanager\Lfm::routes();
});