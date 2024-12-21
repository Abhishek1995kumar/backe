<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HMS\{HmsDashboardController};
use App\Http\Controllers\Admin\Grocery\{GroceryDashboardController, ProductController};
use App\Http\Controllers\Admin\{AdminController, TemplateController, DatabaseController, 
    ModuleController};

/** Admin Routes */
Route::prefix('admin')->group(function() {
    Route::get('/', function () { return view('admin.admin'); });
    Route::get('login', [AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('login/submit', [AdminController::class, 'login'])->name('admin.login.submit');

});


Route::middleware('admin')->prefix('admin')->group(function() {
    Route::get('show/master/blade', [TemplateController::class, 'setModule']);
    // Employee Settings
    Route::get('profile', [AdminController::class, 'profile']);
    Route::get('edit/profile', [AdminController::class, 'editProfile']);
    Route::post('update/profile', [AdminController::class, 'updateProfile']);
    Route::get('change/password', [AdminController::class, 'changePassword']);
    Route::post('update/password', [AdminController::class, 'updatePassword']);
    Route::get('onboarding', [AdminController::class, 'onboardingList'])->name('admin.onboarding.list');
    Route::post('delete/employee', [AdminController::class, 'editProfile']);

    Route::get('dashboard', [TemplateController::class, 'dashboard']);
    Route::get('settings', [TemplateController::class, 'adminSettings']);
    Route::get('employee/list/page', [TemplateController::class, 'adminDetails']);
    Route::get('tool/dashboard', [TemplateController::class, 'adminSubModuleManagement'])->name('admin.template.index');
    Route::get('module/list', [TemplateController::class, 'childModuleManagement']);
    Route::get('menu/builder/list/page', [TemplateController::class, 'menuBuilderList']);
    Route::get('compass/list/page', [TemplateController::class, 'compassList']);
    Route::get('bread/list/page', [TemplateController::class, 'breadList']);

    // Module management
    Route::get('module/parent/list', [ModuleController::class, 'moduleList']);
    Route::post('module/create', [ModuleController::class, 'createModule']);
    Route::get('module/edit/{id}', [ModuleController::class, 'editModule']);
    Route::post('module/update/{id}', [ModuleController::class, 'updateModule']);
    Route::post('module/show/{id}', [ModuleController::class, 'showModule']);
    Route::post('module/delete/{id}', [ModuleController::class, 'deleteModule']);
    
    Route::get('module/sub/list', [ModuleController::class, 'subModuleList']);
    Route::post('sub/module/show/{id}', [ModuleController::class, 'showSubModule']);
    Route::post('sub/module/create', [ModuleController::class, 'createSubModule']);
    Route::get('sub/module/edit/{id}', [ModuleController::class, 'editSubModule']);
    Route::post('sub/module/update/{id}', [ModuleController::class, 'updateSubModule']);
    Route::post('sub/module/delete/{id}', [ModuleController::class, 'deleteSubModule']);
    
    Route::get('child/module/list', [ModuleController::class, 'childModuleList']);
    Route::post('child/module/show/{id}', [ModuleController::class, 'showChildModule']);
    Route::post('child/module/create', [ModuleController::class, 'createChildModule']);
    Route::get('child/module/update', [ModuleController::class, 'updateChildModuleList']);
    Route::get('child/module/show', [ModuleController::class, 'showChildModuleList']);
    Route::get('child/module/delete', [ModuleController::class, 'deleteChildModuleList']);
    
    Route::get('module/mapping/list', [ModuleController::class, 'listModuleMapping']);
    Route::get('module/mapping/create', [ModuleController::class, 'createModuleMapping']);
    // Route::get('module-mapping/list', [ModuleController::class, 'downloadSubModuleExcelSheet']);
    // End Module MANAGEMENT
    
            
    // Bulk upload parent/sub/child module
    Route::get('all/sample/download/link', [ModuleController::class, 'downloadAllSampleModuleExcelLinkUrl']);
    Route::get('sub-module/sample/download', [ModuleController::class, 'downloadSubModuleExcelSheet']);
    Route::post('bulk/sub/module/create', [ModuleController::class, 'uploadSubModuleExcelSheet']);
    
    Route::get('child-module/sample/download', [ModuleController::class, 'downloadChildModuleExcelSheet']);

    // Model migration and controller create from frontend
    Route::get('database/table-list', [DatabaseController::class, 'tableList'])->name('admin.template.table-list');
    Route::get('database/create-table', [DatabaseController::class, 'createTable'])->name('admin.template.create-table');
    Route::post('database/save', [DatabaseController::class, 'saveTable'])->name('admin.template.save');
    Route::get('database/create-bread', [DatabaseController::class, 'createBread'])->name('admin.template.create-bread');
    Route::post('database/bread-save', [DatabaseController::class, 'saveBread'])->name('admin.template.bread-save');
    
    
    
    // HMS URL 
    Route::group(['prefix'=>'hms'], function() {
        Route::get('dashboard', [HmsDashboardController::class, 'hmsDashboard']);
        
    });
    
    
    // Grocery Url
    Route::group(['prefix'=>'grocery'], function() {
        Route::get('sub/module/list', [GroceryDashboardController::class, 'grocerySubModuleDashboard']);
        Route::get('product/list', [ProductController::class, 'productList']);
       
    });
    
    
    // Bulk employee create --
    Route::get('sample/excel/page', [AdminController::class, 'sampleExcelDownloandPage']);
    Route::post('sample/download', [AdminController::class, 'bulkEmployeeOnboarding']);
    
    // create new employee
    Route::get('register', [AdminController::class, 'employeeOnboardingForm'])->name('admin.register');
    Route::post('register/submit', [AdminController::class, 'employeeOnboardingSubmit'])->name('admin.register.submit');
    // Logout
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    // Test Apis
    
});





