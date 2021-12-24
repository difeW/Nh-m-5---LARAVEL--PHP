<?php

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

Route::get('/', function () {
    return view('welcome');
});


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
//Frontend 
Route::get('/',[App\Http\Controllers\HomeController::class, 'index']);
Route::get('/trang-chu',[App\Http\Controllers\HomeController::class, 'index']);
Route::get('/404',[App\Http\Controllers\HomeController::class, 'error_page']);
Route::post('/tim-kiem',[App\Http\Controllers\HomeController::class, 'search']);

//Danh muc san pham trang chu
Route::get('/danh-muc/{slug_category_product}',[App\Http\Controllers\CategoryProduct::class, 'show_category_home']);
Route::get('/thuong-hieu/{brand_slug}',[App\Http\Controllers\BrandProduct::class, 'show_brand_home']);
Route::get('/chi-tiet/{product_slug}',[App\Http\Controllers\ProductController::class, 'details_product']);

//Backend
Route::get('/admin',[App\Http\Controllers\AdminController::class, 'index']);
Route::get('/dashboard',[App\Http\Controllers\AdminController::class, 'show_dashboard']);
Route::get('/logout',[App\Http\Controllers\AdminController::class, 'logout']);
Route::post('/admin-dashboard',[App\Http\Controllers\AdminController::class, 'dashboard']);


//Category Product
Route::get('/add-category-product',[App\Http\Controllers\CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}',[App\Http\Controllers\CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}',[App\Http\Controllers\CategoryProduct::class, 'delete_category_product']);
Route::get('/all-category-product',[App\Http\Controllers\CategoryProduct::class, 'all_category_product']);

Route::post('/export-csv',[App\Http\Controllers\CategoryProduct::class, 'export_csv']);
Route::post('/import-csv',[App\Http\Controllers\CategoryProduct::class, 'import_csv']);


Route::get('/unactive-category-product/{category_product_id}',[App\Http\Controllers\CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}',[App\Http\Controllers\CategoryProduct::class, 'active_category_product']);

//Lien he
Route::get('/lien-he',[App\Http\Controllers\ContactController::class, 'lien_he']);

//Send Mail 
Route::get('/send-mail',[App\Http\Controllers\HomeController::class, 'send_mail']);

//Login facebook
Route::get('/login-facebook',[App\Http\Controllers\AdminController::class,'login_facebook']);
Route::get('/admin/callback',[App\Http\Controllers\AdminController::class,'callback_facebook']);

//Login google
Route::get('/login-google','AdminController@login_google');
Route::get('/google/callback','AdminController@callback_google');

Route::post('/save-category-product',[App\Http\Controllers\CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}',[App\Http\Controllers\CategoryProduct::class, 'update_category_product']);
//Brand Product
Route::get('/add-brand-product',[App\Http\Controllers\BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}',[App\Http\Controllers\BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}',[App\Http\Controllers\BrandProduct::class, 'delete_brand_product']);
Route::get('/all-brand-product',[App\Http\Controllers\BrandProduct::class, 'all_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}',[App\Http\Controllers\BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}',[App\Http\Controllers\BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product',[App\Http\Controllers\BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}',[App\Http\Controllers\BrandProduct::class, 'update_brand_product']);



//Product
// Route::group(['middleware' => 'roles', 'roles'=>['admin','author']], function () {
	Route::get('/add-product',[App\Http\Controllers\ProductController::class, 'add_product']);
	Route::get('/edit-product/{product_id}',[App\Http\Controllers\ProductController::class, 'edit_product']);
// });
Route::get('userls',
		[
			'usels'=>[App\Http\Controllers\UserController::class, 'index'],
			'as'=> 'Users',
			'middleware'=> 'roles'
			// 'roles' => ['admin','author']
		]);
Route::get('users',[App\Http\Controllers\UserController::class, 'index']);
Route::get('add-users',[App\Http\Controllers\UserController::class, 'add_users']);
Route::post('store-users',[App\Http\Controllers\UserController::class, 'store_users']);
Route::post('assign-roles',[App\Http\Controllers\UserController::class, 'assign_users']);



Route::get('/delete-product/{product_id}',[App\Http\Controllers\ProductController::class, 'delete_product']);
Route::get('/all-product',[App\Http\Controllers\ProductController::class, 'all_product']);
Route::get('/unactive-product/{product_id}',[App\Http\Controllers\ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}',[App\Http\Controllers\ProductController::class, 'active_product']);
Route::post('/save-product',[App\Http\Controllers\ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}',[App\Http\Controllers\ProductController::class, 'update_product']);

//Coupon
Route::post('/check-coupon',[App\Http\Controllers\CartController::class, 'check_coupon']);

Route::get('/unset-coupon',[App\Http\Controllers\CouponController::class, 'unset_coupon']);
Route::get('/insert-coupon',[App\Http\Controllers\CouponController::class, 'insert_coupon']);
Route::get('/delete-coupon/{coupon_id}',[App\Http\Controllers\CouponController::class, 'delete_coupon']);
Route::get('/list-coupon',[App\Http\Controllers\CouponController::class, 'list_coupon']);
Route::post('/insert-coupon-code',[App\Http\Controllers\CouponController::class, 'insert_coupon_code']);

//Cart
Route::post('/update-cart-quantity',[App\Http\Controllers\CartController::class, 'update_cart_quantity']);
Route::post('/update-cart',[App\Http\Controllers\CartController::class, 'update_cart']);
Route::post('/save-cart',[App\Http\Controllers\CartController::class, 'save_cart']);
Route::post('/add-cart-ajax',[App\Http\Controllers\CartController::class, 'add_cart_ajax']);
Route::get('/show-cart',[App\Http\Controllers\CartController::class, 'show_cart']);
Route::get('/gio-hang',[App\Http\Controllers\CartController::class, 'gio_hang']);
Route::get('/delete-to-cart/{rowId}',[App\Http\Controllers\CartController::class, 'delete_to_cart']);
Route::get('/del-product/{session_id}',[App\Http\Controllers\CartController::class, 'delete_product']);
Route::get('/del-all-product',[App\Http\Controllers\CartController::class, 'delete_all_product']);

//Checkout
Route::get('/dang-nhap',[App\Http\Controllers\CheckoutController::class, 'login_checkout']);
Route::get('/del-fee',[App\Http\Controllers\CheckoutController::class, 'del_fee']);

Route::get('/logout-checkout',[App\Http\Controllers\CheckoutController::class, 'logout_checkout']);
Route::get('/handcash',[App\Http\Controllers\CheckoutController::class, 'handcash']);
Route::get('/order-detail/{order_id}',[App\Http\Controllers\OrderController::class, 'show_detail_order']);
Route::post('/add-customer',[App\Http\Controllers\CheckoutController::class, 'add_customer']);
Route::post('/order-place',[App\Http\Controllers\CheckoutController::class, 'order_place']);
Route::post('/login-customer',[App\Http\Controllers\CheckoutController::class, 'login_customer']);
Route::get('/checkout',[App\Http\Controllers\CheckoutController::class, 'checkout']);
Route::get('/payment/{ship_id}',[App\Http\Controllers\CheckoutController::class, 'payment']);
Route::get('/delete-shipping/{ship_id}',[App\Http\Controllers\CheckoutController::class, 'delete_shipping']);
Route::post('/save-checkout-customer',[App\Http\Controllers\CheckoutController::class, 'save_checkout_customer']);
Route::post('/calculate-fee',[App\Http\Controllers\CheckoutController::class, 'calculate_fee']);
Route::post('/select-delivery-home',[App\Http\Controllers\CheckoutController::class, 'select_delivery_home']);
Route::post('/confirm-order',[App\Http\Controllers\CheckoutController::class, 'confirm_order']);

//Order
Route::get('/delete-order/{order_id}',[App\Http\Controllers\OrderController::class, 'order_code']);
Route::get('/print-order/{checkout_code}',[App\Http\Controllers\OrderController::class, 'print_order']);
Route::get('/manage-order',[App\Http\Controllers\OrderController::class, 'manage_order']);
Route::get('/view-order/{order_id}',[App\Http\Controllers\OrderController::class, 'view_order']);
Route::post('/update-order-qty',[App\Http\Controllers\OrderController::class, 'update_order_qty']);
Route::post('/update-qty',[App\Http\Controllers\OrderController::class, 'update_qty']);


//Delivery
Route::get('/delivery',[App\Http\Controllers\DeliveryController::class, 'delivery']);
Route::post('/select-delivery',[App\Http\Controllers\DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery',[App\Http\Controllers\DeliveryController::class, 'insert_delivery']);
Route::post('/select-feeship',[App\Http\Controllers\DeliveryController::class, 'select_feeship']);
Route::post('/update-delivery',[App\Http\Controllers\DeliveryController::class, 'update_delivery']);

//Banner
Route::get('/manage-slider',[App\Http\Controllers\SliderController::class, 'manage_slider']);
Route::get('/add-slider',[App\Http\Controllers\SliderController::class, 'add_slider']);
Route::get('/delete-slide/{slide_id}',[App\Http\Controllers\SliderController::class, 'delete_slide']);
Route::post('/insert-slider',[App\Http\Controllers\CheckoutController::class, 'insert_slider']);
Route::get('/unactive-slide/{slide_id}',[App\Http\Controllers\SliderController::class, 'unactive_slide']);
Route::get('/active-slide/{slide_id}',[App\Http\Controllers\SliderController::class, 'active_slide']);

Route::get('/shipping',[App\Http\Controllers\CheckoutController::class, 'show_shipping']);
Route::post('/tinh_tien_giam',[App\Http\Controllers\CheckoutController::class, 'tinh_tien_giam']);
Route::get('/view-order-detail',[App\Http\Controllers\OrderController::class, 'view_order_detail']);
Route::post('/huy_don_hang',[App\Http\Controllers\OrderController::class, 'huy_don_hang']);
Route::post('/nhan_don_hang',[App\Http\Controllers\OrderController::class, 'nhan_don_hang']);