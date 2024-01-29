<?php

use App\Http\Controllers\AssessmentReportController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\FirewallController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternetController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AssessorController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\NvrController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\RemarkController;
use App\Http\Controllers\SwitchesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth')->name('backend.')->group(function(){
    Route::get('/',[HomeController::class,'index'])->name('dashboard');
    Route::get('dashboard/data',[HomeController::class,'data'])->name('dashboard.data');


    Route::prefix('inquiry')->name('inquiry.')->group(function(){
        Route::get('/',[InquiryController::class,'index'])->name('index')->middleware('permission:inquiry.list');
        Route::get('/datatableAdmin',[InquiryController::class,'datatableAdmin'])->name('datatableAdmin')->middleware('permission:inquiry.list');
        Route::get('/datatable',[InquiryController::class,'datatable'])->name('datatable')->middleware('permission:inquiry.list');
        Route::get('/{id}/show',[InquiryController::class,'show'])->name('show')->middleware('permission:inquiry.list');
        Route::get('/{id}/edit',[InquiryController::class,'edit'])->name('edit')->middleware('permission:inquiry.manage');
        Route::get('/{id}/view',[InquiryController::class,'view'])->name('view')->middleware('permission:inquiry.manage');
        Route::put('/{id}',[InquiryController::class,'update'])->name('update')->middleware('permission:inquiry.manage');
        Route::delete('/{id}',[InquiryController::class,'destroy'])->name('destroy')->middleware('permission:inquiry.delete');
        Route::post('/{id}/{status}',[InquiryController::class,'updateRequest'])->name('updateRequest');
    });
    Route::prefix('remark')->name('remark.')->group(function(){
        Route::post('/update',[RemarkController::class,'update'])->name('update');
        Route::get('/datatable/{id}',[RemarkController::class,'datatable'])->name('datatable');
        Route::delete('/{id}',[RemarkController::class,'destroy'])->name('destroy');
    });

    Route::prefix('switches')->name('switches.')->group(function(){
        Route::get('/',[SwitchesController::class,'index'])->name('index')->middleware('permission:switches.list');
        Route::get('/datatable',[SwitchesController::class,'datatable'])->name('datatable')->middleware('permission:switches.list');
        Route::get('/{id}/edit',[SwitchesController::class,'edit'])->name('edit')->middleware('permission:switches.manage');
        Route::put('/{id}',[SwitchesController::class,'update'])->name('update')->middleware('permission:switches.manage');
        Route::delete('/{id}',[SwitchesController::class,'destroy'])->name('destroy')->middleware('permission:switches.delete');
    });

    Route::prefix('firewall')->name('firewall.')->group(function(){
        Route::get('/',[FirewallController::class,'index'])->name('index')->middleware('permission:firewall.list');
        Route::get('/datatable',[FirewallController::class,'datatable'])->name('datatable')->middleware('permission:firewall.list');
        Route::get('/{id}/edit',[FirewallController::class,'edit'])->name('edit')->middleware('permission:firewall.manage');
        Route::put('/{id}',[FirewallController::class,'update'])->name('update')->middleware('permission:firewall.manage');
        Route::delete('/{id}',[FirewallController::class,'destroy'])->name('destroy')->middleware('permission:firewall.delete');
    });

    Route::prefix('internet')->name('internet.')->group(function() {
        Route::get('/', [InternetController::class, 'index'])->name('index')->middleware('permission:internet.list');
        Route::get('/datatable', [InternetController::class, 'datatable'])->name('datatable')->middleware('permission:internet.list');
        Route::get('/{id}/edit', [InternetController::class, 'edit'])->name('edit')->middleware('permission:internet.manage');
        Route::put('/{id}', [InternetController::class, 'update'])->name('update')->middleware('permission:internet.manage');
        Route::delete('/{id}', [InternetController::class, 'destroy'])->name('destroy')->middleware('permission:internet.delete');
    });

    Route::prefix('nvr')->name('nvr.')->group(function(){
        Route::get('/',[NvrController::class,'index'])->name('index')->middleware('permission:nvr.list');
        Route::get('/datatable',[NvrController::class,'datatable'])->name('datatable')->middleware('permission:nvr.list');
        Route::get('/{id}/edit',[NvrController::class,'edit'])->name('edit')->middleware('permission:nvr.manage');
        Route::put('/{id}',[NvrController::class,'update'])->name('update')->middleware('permission:nvr.manage');
        Route::delete('/{id}',[NvrController::class,'destroy'])->name('destroy')->middleware('permission:nvr.delete');
    });

    Route::prefix('outlet')->name('outlet.')->group(function(){
        Route::get('/',[OutletController::class,'index'])->name('index')->middleware('permission:outlet.list');
        Route::get('/datatable',[OutletController::class,'datatable'])->name('datatable')->middleware('permission:outlet.list');
        Route::get('/{id}/edit',[OutletController::class,'edit'])->name('edit')->middleware('permission:outlet.manage');
        Route::put('/{id}',[OutletController::class,'update'])->name('update')->middleware('permission:outlet.manage');
        Route::delete('/{id}',[OutletController::class,'destroy'])->name('destroy')->middleware('permission:outlet.delete');
    });

    Route::prefix('domain')->name('domain.')->group(function(){
        Route::get('/',[DomainController::class,'index'])->name('index')->middleware('permission:domain.list');
        Route::get('/datatable',[DomainController::class,'datatable'])->name('datatable')->middleware('permission:domain.list');
        Route::get('/{id}/edit',[DomainController::class,'edit'])->name('edit')->middleware('permission:domain.manage');
        Route::put('/{id}',[DomainController::class,'update'])->name('update')->middleware('permission:domain.manage');
        Route::delete('/{id}',[DomainController::class,'destroy'])->name('destroy')->middleware('permission:domain.delete');
    });

    Route::prefix('location')->name('location.')->group(function(){
        Route::get('/',[LocationController::class,'index'])->name('index')->middleware('permission:location.list');
        Route::get('/datatable',[LocationController::class,'datatable'])->name('datatable')->middleware('permission:location.list');
        Route::get('/{id}/edit',[LocationController::class,'edit'])->name('edit')->middleware('permission:location.manage');
        Route::put('/{id}',[LocationController::class,'update'])->name('update')->middleware('permission:location.manage');
        Route::delete('/{id}',[LocationController::class,'destroy'])->name('destroy')->middleware('permission:location.delete');
    });

    Route::prefix('brand')->name('brand.')->group(function(){
        Route::get('/',[BrandController::class,'index'])->name('index')->middleware('permission:brand.list');
        Route::get('/datatable',[BrandController::class,'datatable'])->name('datatable')->middleware('permission:brand.list');
        Route::get('/{id}/edit',[BrandController::class,'edit'])->name('edit')->middleware('permission:brand.manage');
        Route::put('/{id}',[BrandController::class,'update'])->name('update')->middleware('permission:brand.manage');
        Route::delete('/{id}',[BrandController::class,'destroy'])->name('destroy')->middleware('permission:brand.delete');
    });

    //User and Role Routes
    Route::prefix('user')->name('user.')->group(function(){
        Route::get('/',[UserController::class,'index'])->name('index')->middleware('permission:user.list');
        Route::get('/datatable',[UserController::class,'datatable'])->name('datatable')->middleware('permission:user.list');
        Route::get('/{id}/edit',[UserController::class,'edit'])->name('edit')->middleware('permission:user.manage');
        Route::put('/{id}',[UserController::class,'update'])->name('update')->middleware('permission:user.manage');
        Route::delete('/{id}',[UserController::class,'destroy'])->name('destroy')->middleware('permission:user.delete');
    });

    Route::prefix('role')->name('role.')->group(function(){
        Route::get('/',[RoleController::class,'index'])->name('index')->middleware('permission:role.list');
        Route::get('datatable',[RoleController::class,'datatable'])->name('datatable')->middleware('permission:role.list');
        Route::get('/{id}/edit',[RoleController::class,'edit'])->name('edit')->middleware('permission:role.manage');
        Route::put('/{id}',[RoleController::class,'update'])->name('update')->middleware('permission:role.manage');
        Route::delete('/{id}',[RoleController::class,'destroy'])->name('destroy')->middleware('permission:role.delete');
    });

});

Auth::routes(['register'=>false]);

