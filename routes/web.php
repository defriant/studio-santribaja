<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\GalleryController;

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

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');
});

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('login-attempt', 'login_attempt');
    Route::get('logout', 'logout');
    Route::post('user/change-password', 'change_password');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard/visitor/today/chart', 'today_visitor');
        Route::post('dashboard/visitor/yearly/chart', 'yearly_visitor');
        Route::post('dashboard/visitor/yearly/by-country', 'yearly_by_country');
        Route::post('dashboard/visitor/update', 'visitor_update');
    });

    Route::get('product', function () {
        return view('product');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('product/kategori/get', 'kategori_get');
        Route::post('product/kategori/description/update', 'update_category_desc');
        Route::post('product/kategori/description/display', 'update_category_display');
        Route::get('product/independent-category/get', 'independent_product_get');
        Route::post('product/kategori/add', 'kategori_add');
        Route::post('product/kategori/update', 'kategori_update');
        Route::post('product/kategori/delete', 'kategori_delete');

        Route::get('product/get', 'product_get');
        Route::post('product/add', 'product_add');
        Route::post('product/update', 'product_update');
        Route::post('product/delete', 'product_delete');
        Route::post('product/switch-order', 'switch_order');
    });

    Route::get('album', function () {
        return view('album');
    });

    Route::controller(AlbumController::class)->group(function () {
        Route::get('album/get', 'album_get');
        Route::post('album/add', 'album_add');
        Route::post('album/edit', 'album_edit');
        Route::post('album/delete', 'album_delete');
        Route::post('album/description/update', 'album_description');
        Route::post('album/description/display', 'album_description_display');
    });

    Route::get('gallery', function () {
        return view('gallery');
    });

    Route::controller(GalleryController::class)->group(function () {
        Route::get('gallery/get', 'gallery_get');
        Route::post('gallery/add', 'gallery_add');
        Route::post('gallery/edit', 'gallery_edit');
        Route::post('gallery/delete', 'gallery_delete');
        Route::post('gallery/description/update', 'gallery_description');
        Route::post('gallery/description/display', 'gallery_description_display');
    });

    Route::get('distributor', function () {
        return view('distributor');
    });

    Route::controller(DistributorController::class)->group(function () {
        Route::get('distributor/get', 'distributor_get');
        Route::post('distributor/add', 'distributor_add');
        Route::post('distributor/edit', 'distributor_edit');
        Route::post('distributor/delete', 'distributor_delete');
    });

    Route::get('article', function () {
        return view('article');
    });

    Route::controller(ArticleController::class)->group(function () {
        Route::get('article/get', 'article_get');
        Route::post('article/add', 'article_add');
        Route::post('article/edit', 'article_edit');
        Route::post('article/delete', 'article_delete');
        Route::post('article/description/update', 'article_description');
        Route::post('article/description/display', 'article_description_display');
    });

    Route::get('content-manager/information', function () {
        return view('content-manager.information');
    });

    Route::controller(InformationController::class)->group(function () {
        Route::get('content-manager/information/get', 'information_get');

        Route::post('content-manager/information/general/update', 'update_general');
        Route::post('content-manager/information/about/update', 'update_about');

        Route::post('content-manager/about/image/add', 'about_image_add');
        Route::get('content-manager/about/image/{id}/delete', 'about_image_delete');
        Route::post('content-manager/about/image/{id}/update', 'about_image_update');
    });

    Route::get('content-manager/main-banner', function () {
        return view('content-manager.main-banner');
    });

    Route::get('content-manager/other-banner', function () {
        return view('content-manager.other-banner');
    });

    Route::controller(BannerController::class)->group(function () {
        Route::get('content-manager/main-banner/get', 'main_banner_get');
        Route::post('content-manager/main-banner/update', 'main_banner_update');
        Route::post('content-manager/main-banner/delete', 'main_banner_delete');

        Route::get('content-manager/other-banner/get', 'other_banner_get');
        Route::post('content-manager/other-banner/update', 'other_banner_update');
    });

    Route::get('content-manager/section', function () {
        return view('content-manager.section');
    });

    Route::controller(SectionController::class)->group(function () {
        Route::get('content-manager/section/get', 'get_section');
        Route::post('content-manager/section/switch-order', 'switch_order');
        Route::post('content-manager/section/status', 'status');
    });

    Route::controller(MailboxController::class)->group(function () {
        Route::get('mailbox', 'mailbox');
        Route::get('mailbox/get', 'get_mailbox');
        Route::post('mailbox/read', 'read_mailbox');
        Route::post('mailbox/delete', 'delete_mailbox');
    });
});
