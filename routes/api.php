<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\CustomerController;


Route::group(['namespace' => 'Api','prefix'=>'v1','middleware' => 'api'], function(){
    
     Route::get('app-config', [FrontendController::class, 'appconfig']);
     
     Route::get('category-menu', [FrontendController::class, 'categorymenu']);
 
     Route::get('contactinfo', [FrontendController::class, 'contactinfo']);
     
    //  Home Page Api End =================================
    
    Route::get('category/{id}', [FrontendController::class, 'catproduct']);
    
    //=================  Home Page Api End=======================
    
    Route::get('slider', [FrontendController::class, 'slider']);
    Route::get('bestdeal-product', [FrontendController::class, 'bestdealproduct']);
    Route::get('product-with-category', [FrontendController::class, 'product_with_Category']);
    Route::get('brands', [FrontendController::class, 'brands']);
    Route::get('category/{id}', [FrontendController::class, 'category'])->name('category');
    Route::get('product/{id}', [FrontendController::class, 'productDetails']);
    Route::get('livesearch', [FrontendController::class, 'livesearch']);
    Route::get('/shipping-charge', [FrontendController::class, 'shipping_charge'])->name('shipping.charge');
    Route::get('districts', [FrontendController::class, 'districts'])->name('districts');
    
    Route::get('stock-check', [FrontendController::class, 'stock_check'])->name('stock_check');
    
    
      // customer routes
    Route::post('customer/login', [CustomerController::class, 'login']);    
    Route::post('customer/store', [CustomerController::class, 'register']);    
    
    
    Route::post('customer/resend-otp', [CustomerController::class, 'resendotp']);
    Route::post('customer/verify', [CustomerController::class, 'account_verify']);
    Route::post('customer/forgot-password', [CustomerController::class, 'forgot_password']);
    Route::post('customer/resend-forgot', [CustomerController::class, 'resend_forgot']);
    Route::post('customer/forgot-verify', [CustomerController::class, 'forgot_verify']);
    Route::get('customer/setting', [CustomerController::class, 'setting']);
    Route::post('customer/order-save', [CustomerController::class, 'order_save']);
    
    Route::get('customer/order-track/result', [CustomerController::class, 'order_track'])->name('customer.order_track');
    Route::get('/customer/order/invoice/{id}', [CustomerController::class, 'invoice']);
    Route::post('/customer/coupon', [CustomerController::class, 'customer_coupon'])->name('customer.coupon');
    

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
