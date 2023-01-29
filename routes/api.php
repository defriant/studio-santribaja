<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\DashboardController;

// Route::controller(APIController::class)->group(function () {
//     Route::get('company-identity', 'get_informations');
//     Route::get('main-banner', 'get_main_banner');
//     Route::get('sections', 'get_sections');
//     Route::get('category', 'get_category');

//     Route::get('product/{id}', 'get_product_by_id');
//     Route::get('product/category/{id}', 'get_product_by_category');

//     Route::get('distributors', 'get_distributor');
//     Route::post('distributor/search', 'search_distributor');

//     Route::post('contact/send', 'add_mailbox');

//     Route::post('generate/user/account', 'generate_user_account');
// });

Route::controller(APIController::class)->group(function () {
    Route::get('/company', 'company');
    Route::get('/home', 'home');
});

Route::controller(DashboardController::class)->group(function () {
    Route::post('dashboard/visitor/{token}/update', 'visitor_update');
});

Route::any('/{any}', function () {
    return response()->json([
        'error' => true,
        'message' => 'Resource not found'
    ], 404);
})->where('any', '.*');
