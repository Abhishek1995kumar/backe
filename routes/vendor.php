<?php

use App\Http\Controllers\Vendor\Auth\VendorController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'vendor'], function() {
    Route::get('welcome', function () {
        return view('vendors.vendor-welcome');
    });
    Route::get('login', [VendorController::class, 'vendorLoginForm'])->name('vendor.login');
    Route::post('login/submit', [VendorController::class, 'submitVendorLogin'])->name('vendor.login.submit');
    Route::get('register', [VendorController::class, 'vendorRegisterForm'])->name('vendor.register');
    Route::post('register/submit', [VendorController::class, 'submitVendorRegister'])->name('vendor.register.submit');

});


Route::group(['middleware'=>'vendor', 'prefix' => 'vendor'], function() {
    Route::get('dashboard', [VendorController::class, 'vendorDashboard']);
});

