<?php

use App\Http\Controllers\Home\AuthController;
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


Route::group(['prefix' => 'admin'] , function (){
    Route::get('/',  [App\Http\Controllers\Admin\PanelController::class, 'index'])->middleware(['permission:نمایش داشبورد']);

    /////////////////////////////////////////////////////////////// gallery
    Route::match(['get', 'post'],'/gallery',  [App\Http\Controllers\Admin\GalleryController::class, 'index'])->middleware(['permission:نمایش همه تصویر ها|حذف تصویر|ویرایش تصویر|نمایش تصویر های خودش|افزودن تصویر']);
    Route::post('/gallery/create',  [App\Http\Controllers\Admin\GalleryController::class, 'create'])->middleware(['permission:افزودن تصویر']);
    Route::post('/gallery/create-image',  [App\Http\Controllers\Admin\GalleryController::class, 'createImage'])->middleware(['permission:افزودن تصویر']);
    Route::post('/gallery/remove',  [App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->middleware(['permission:حذف تصویر']);
    Route::post('/gallery/show',  [App\Http\Controllers\Admin\GalleryController::class, 'show']);
    Route::post('/gallery/crop-image',  [App\Http\Controllers\Admin\GalleryController::class, 'cropImage']);
    Route::get('/get-image',  [App\Http\Controllers\Admin\GalleryController::class, 'getImage']);

    /////////////////////////////////////////////////////////////// user
    Route::match(['get', 'post'],'/user',  [App\Http\Controllers\Admin\UserController::class, 'index'])->middleware(['permission:نمایش کاربر|حذف کاربر|ویرایش کاربر|افزودن کاربر']);

    /////////////////////////////////////////////////////////////// role
    Route::match(['get', 'post'],'/role',  [App\Http\Controllers\Admin\RoleController::class, 'index'])->middleware(['permission:نمایش مقام|حذف مقام|ویرایش مقام|افزودن مقام']);

    /////////////////////////////////////////////////////////////// tax
    Route::match(['get', 'post'],'/category',  [App\Http\Controllers\Admin\CategoryController::class, 'index'])->middleware(['permission:نمایش همه دسته ها|حذف دسته|ویرایش دسته|نمایش دسته های خودش|افزودن دسته']);
    Route::match(['get', 'post'],'/brand',  [App\Http\Controllers\Admin\BrandController::class, 'index'])->middleware(['permission:نمایش همه برند ها|حذف برند|ویرایش برند|نمایش برند های خودش|افزودن برند']);
    Route::match(['get', 'post'],'/color',  [App\Http\Controllers\Admin\ColorController::class, 'index'])->middleware(['permission:نمایش همه رنگ ها|حذف رنگ|ویرایش رنگ|نمایش رنگ های خودش|افزودن رنگ']);
    Route::match(['get', 'post'],'/size',  [App\Http\Controllers\Admin\SizeController::class, 'index'])->middleware(['permission:نمایش همه سایز ها|حذف سایز|ویرایش سایز|نمایش سایز های خودش|افزودن سایز']);
    Route::match(['get', 'post'],'/page',  [App\Http\Controllers\Admin\PageController::class, 'index'])->middleware(['permission:حذف برگه|ویرایش برگه|نمایش برگه ها|افزودن برگه']);
    Route::match(['get', 'post'],'/carrier',  [App\Http\Controllers\Admin\CarrierController::class, 'index'])->middleware(['permission:حذف برگه|ویرایش برگه|نمایش برگه ها|افزودن برگه']);
    Route::match(['get', 'post'],'/time',  [App\Http\Controllers\Admin\TimeController::class, 'index'])->middleware(['permission:حذف برگه|ویرایش برگه|نمایش برگه ها|افزودن برگه']);

    ////////////////////////////////////////////////////////////////////////////////// setting
    Route::match(['get', 'post'],'/setting-comment',  [App\Http\Controllers\Admin\SettingController::class, 'comment'])->middleware(['permission:تنظیمات دیدگاه']);
    Route::match(['get', 'post'],'/setting-template',  [App\Http\Controllers\Admin\VidgetController::class, 'template'])->middleware(['permission:تنظیمات قالب سایت']);
    Route::match(['get', 'post'],'/site-setting',  [App\Http\Controllers\Admin\SettingController::class, 'site'])->middleware(['permission:تنظیمات سایت']);
    Route::match(['get', 'post'],'/seo-setting',  [App\Http\Controllers\Admin\SettingController::class, 'seo'])->middleware(['permission:تنظیمات سایت']);

    /////////////////////////////////////////////////////////////// post
    Route::match(['get', 'post'],'/post/create',  [App\Http\Controllers\Admin\PostController::class, 'create'])->middleware(['permission:افزودن پست']);
    Route::match(['get', 'post'],'/post',  [App\Http\Controllers\Admin\PostController::class, 'index'])->middleware(['permission:نمایش همه پست ها|نمایش پست های خودش|حذف پست|ویرایش پست|افزودن پست']);
    Route::match(['get', 'post'],'/post/{post}/edit',  [App\Http\Controllers\Admin\PostController::class, 'edit'])->middleware(['permission:ویرایش پست']);
    Route::match(['get', 'post'],'/post/{post}/show',  [App\Http\Controllers\Admin\PostController::class, 'show'])->middleware(['permission:نمایش همه پست ها|نمایش پست های خودش']);
    Route::post('/post/get-digikala',  [App\Http\Controllers\Admin\PostController::class, 'digikala']);

    ///////////////////////////////////////// excel
    Route::match(['get', 'post'],'/excel',  [App\Http\Controllers\Admin\ExcelController::class, 'index'])->middleware(['permission:نمایش رویداد|حذف رویداد']);
    Route::get('/get-excel/{data}',  [App\Http\Controllers\Admin\ExcelController::class, 'getExcel'])->middleware(['permission:نمایش رویداد|حذف رویداد']);

    //////////////////////////////////////////////////////////////////////////////// news
    Route::match(['get', 'post'],'/news',  [App\Http\Controllers\Admin\NewsController::class, 'index'])->middleware(['permission:نمایش پست|حذف پست|ویرایش پست']);
    Route::match(['get', 'post'],'/news/create',  [App\Http\Controllers\Admin\NewsController::class, 'create'])->middleware(['permission:افزودن پست']);
    Route::match(['get', 'post'],'/news/{news}/edit',  [App\Http\Controllers\Admin\NewsController::class, 'edit'])->middleware(['permission:ویرایش پست']);
    Route::get('/news/{news}/show',  [App\Http\Controllers\Admin\NewsController::class, 'show'])->middleware(['permission:نمایش همه پست ها|نمایش پست های خودش']);

    ////////////////////////////////////////////////////////////////////////////////////// pay
    Route::match(['get', 'post'],'/pay',  [App\Http\Controllers\Admin\PayController::class, 'index'])->middleware(['permission:نمایش پرداختی|حذف پرداختی']);
    Route::get('/pay/{pay}',  [App\Http\Controllers\Admin\PayController::class, 'show'])->middleware(['permission:نمایش پرداختی']);
    Route::get('/show-pay/{pay}',  [App\Http\Controllers\Home\UserController::class, 'showPay1'])->middleware(['permission:نمایش پرداختی']);
    Route::get('/pay/invoice/{pay}',  [App\Http\Controllers\Admin\PayController::class, 'invoice'])->middleware(['permission:نمایش پرداختی']);

    ////////////////////////////////////////////////////////////////////////////////////// pack
    Route::match(['get', 'post'],'/pack',  [App\Http\Controllers\Admin\PackController::class, 'index'])->middleware(['permission:نمایش پک|حذف پک|ویرایش پک|افزودن پک']);

    ///////////////////////////////////////////////////////////////////////////////// search
    Route::post('/search-tax',  [App\Http\Controllers\Admin\SearchController::class, 'tax']);
    Route::post('/tax/create',  [App\Http\Controllers\Admin\SearchController::class, 'taxCreate']);

    /////////////////////////////////////////////////////////////// comment
    Route::match(['get', 'post'],'/comment',  [App\Http\Controllers\Admin\CommentController::class, 'index']);
    Route::match(['get', 'post'],'/comment/{comment}',  [App\Http\Controllers\Admin\CommentController::class, 'edit'])->middleware(['permission:ویرایش دیدگاه']);
});

Route::group(['prefix' => '/'] , function (){
    Route::get('/',  [App\Http\Controllers\Home\IndexController::class, 'index']);
    Route::post('/get-filter-cat-post',  [App\Http\Controllers\Home\IndexController::class, 'getFilterCat']);
    Route::post('/get-suggest-index',  [App\Http\Controllers\Home\IndexController::class, 'getSuggest']);
    Route::post('/show-compares',  [App\Http\Controllers\Home\IndexController::class, 'showCompares']);
    Route::post('/show-fast',  [App\Http\Controllers\Home\IndexController::class, 'showFast']);

    //////////////////////////////////////////////////////////// single
    Route::get('/product/{PostSlug}',  [App\Http\Controllers\Home\SingleController::class, 'single']);
    Route::get('/pack/{PackSlug}',  [App\Http\Controllers\Home\SingleController::class, 'pack']);
    Route::post('/view',  [App\Http\Controllers\Home\ViewController::class, 'view']);
    Route::get('/page/{PageSlug}',  [App\Http\Controllers\Home\SingleController::class, 'page']);
    Route::get('/news/{NewsSlug}',  [App\Http\Controllers\Home\SingleController::class, 'news']);

    /////////////////////////////////////////////// like
    Route::get('/get-like',  [App\Http\Controllers\Home\LikeController::class, 'getLike']);
    Route::post('/like',  [App\Http\Controllers\Home\LikeController::class, 'store']);

    /////////////////////////////////////////////// bookmark
    Route::get('/get-bookmark',  [App\Http\Controllers\Home\BookmarkController::class, 'getBookmark']);
    Route::post('/bookmark',  [App\Http\Controllers\Home\BookmarkController::class, 'store']);

    ///////////////////////////////////////////////////// comment
    Route::post('/send-comment',  [App\Http\Controllers\Home\CommentController::class, 'sendComment']);
    Route::get('/get-comment/{post}',  [App\Http\Controllers\Home\CommentController::class, 'getComment']);
    Route::post('/send-reply',  [App\Http\Controllers\Home\CommentController::class, 'sendReply']);

    //////////////////////////////////////////////////////////// archive
    Route::match(['get', 'post'],'/archive/category/{CategorySlug}',  [App\Http\Controllers\Home\ArchiveController::class, 'category']);
    Route::match(['get', 'post'],'/archive/brand/{BrandSlug}',  [App\Http\Controllers\Home\ArchiveController::class, 'brand']);
    Route::match(['get', 'post'],'/archive/search',  [App\Http\Controllers\Home\ArchiveController::class, 'search']);
    Route::post('/search-advance',  [App\Http\Controllers\Home\ArchiveController::class, 'searchAdvance']);
    Route::match(['get', 'post'],'/archive/suggest',  [App\Http\Controllers\Home\ArchiveController::class, 'suggest']);
    Route::match(['get', 'post'] , '/archive/product/{VidgetSlug}',  [App\Http\Controllers\Home\ArchiveController::class, 'vidget']);
    Route::match(['get', 'post'] , '/archive/pack',  [App\Http\Controllers\Home\ArchiveController::class, 'packs']);
    Route::get('/archive/news',  [App\Http\Controllers\Home\ArchiveController::class, 'news']);
    Route::get('/news/archive/category/{CategorySlug}',  [App\Http\Controllers\Home\ArchiveController::class, 'newsCategory']);

    ///////////////////////////////////////////////////// rate
    Route::post('/rate',  [App\Http\Controllers\Home\RateController::class, 'store']);
    Route::post('/get-rate',  [App\Http\Controllers\Home\RateController::class, 'getRate']);

    ///////////////////////////////////////////////////////////// profile
    Route::get('/profile',  [App\Http\Controllers\Home\UserController::class, 'index']);
    Route::match(['get', 'post'],'/profile/comment',  [App\Http\Controllers\Home\UserController::class, 'comment']);
    Route::match(['get', 'post'],'/profile/personal-info',  [App\Http\Controllers\Home\UserController::class, 'personalInfo']);
    Route::match(['get', 'post'],'/profile/pay',  [App\Http\Controllers\Home\UserController::class, 'pay']);
    Route::get('/pay/{pay}',  [App\Http\Controllers\Home\UserController::class, 'showPay']);
    Route::get('/profile/like',  [App\Http\Controllers\Home\UserController::class, 'like']);
    Route::get('/profile/bookmark',  [App\Http\Controllers\Home\UserController::class, 'bookmark']);
    Route::get('/profile/recently',  [App\Http\Controllers\Home\UserController::class, 'recently']);
    Route::get('/logout',  [App\Http\Controllers\Home\UserController::class, 'logout']);
    Route::get('/show-pay/{PayProperty}',  [App\Http\Controllers\Home\UserController::class, 'showPay1']);
    Route::get('/pay/invoice/{PayProperty}',  [App\Http\Controllers\Home\UserController::class, 'invoice']);

    ///////////////////////////////////////////////////// cart
    Route::post('/add-pack',  [App\Http\Controllers\Home\CartController::class, 'addPack']);
    Route::post('/add-cart',  [App\Http\Controllers\Home\CartController::class, 'addCart']);
    Route::post('/add-cart-single',  [App\Http\Controllers\Home\CartController::class, 'addCartSingle']);
    Route::get('/get-carts',  [App\Http\Controllers\Home\CartController::class, 'getCarts']);
    Route::post('/change-carts',  [App\Http\Controllers\Home\CartController::class, 'changeCarts']);
    Route::post('/delete-cart',  [App\Http\Controllers\Home\CartController::class, 'deleteCart']);
    Route::get('/cart',  [App\Http\Controllers\Home\CartController::class, 'cart']);
    Route::post('/change-carrier',  [App\Http\Controllers\Home\CartController::class, 'changeCarrier']);
    Route::post('/change-time-delivery',  [App\Http\Controllers\Home\CartController::class, 'changeTimeDelivery']);
    Route::match(['get', 'post'],'/user-info-cart',  [App\Http\Controllers\Home\CartController::class, 'userInfoCart']);

    ///////////////////////////////////////////////////// shop
    Route::get('/order',  [App\Http\Controllers\Home\ShopController::class, 'order']);
    Route::get('/shop',  [App\Http\Controllers\Home\ShopController::class, 'add_order']);
    Route::get('/spot/order',  [App\Http\Controllers\Home\ShopController::class, 'orderSpot']);
    Route::get('/spot/shop',  [App\Http\Controllers\Home\ShopController::class, 'add_order_Spot']);

    ////////////////////////////////////////////////////// google login
    Route::get('/google-login', [App\Http\Controllers\Home\GoogleAuthController::class, 'redirectToProvider']);
    Route::get('/callback', [App\Http\Controllers\Home\GoogleAuthController::class, 'handleProviderCallback']);

    ////////////////////////////////////////////////////////////// auth
    Route::get('/login',  [AuthController::class, 'loginPage'])->name('login');
    Route::get('/register',  [AuthController::class, 'loginPage'])->name('register');
    /**/// number
    Route::post('/check-auth',  [AuthController::class, 'check']);
    Route::post('/check-code',  [AuthController::class, 'checkCode']);
    Route::post('/login-auth',  [AuthController::class, 'login']);
    Route::get('/logout-auth',  [AuthController::class, 'logout']);
    Route::post('/make-user',  [AuthController::class, 'makeUser']);
    Route::post('/change-password',  [AuthController::class, 'changePassword']);

    /**/// email
    Route::post('/check-email',  [AuthController::class, 'checkEmail']);
    Route::post('/check-email-code',  [AuthController::class, 'checkEmailCode']);
    Route::post('/login-email',  [AuthController::class, 'loginEmail']);
    Route::post('/change-email-password',  [AuthController::class, 'changeEmailPassword']);
    Route::post('/make-user-email',  [AuthController::class, 'makeUserEmail']);
});
