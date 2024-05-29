<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DistilleryController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ReleaseController;

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
    //if(Auth::check()) {
        return redirect()->route('login');
    // }
    // return view('welcome');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/fetch-states', [ProductCatalogController::class, 'fetchState']);
Route::post('/fetch-merchants-distillery', [BrandController::class, 'fetchmerchant_distillery']);
/* Start Company Routes */
Route::get('/create-company', [ProductCatalogController::class, 'index'])->name('company.createcompany');
Route::get('/list-company', [ProductCatalogController::class, 'show'])->name('company.listcompany');
Route::get('/edit-company/{id}', [ProductCatalogController::class, 'edit'])->name('company.editcompany');
Route::put('/update-company/{id}', [ProductCatalogController::class, 'update'])->name('company.update');
Route::delete('/delete-company/{id}', [ProductCatalogController::class, 'destroy'])->name('company.destroy');
Route::POST('/company', [ProductCatalogController::class, 'create'])->name('product-catalog');
/*End Catalog Routes */

/* Start Brands Routes */
Route::get('/create-brand', [BrandController::class, 'index'])->name('brand.createbrand');
Route::get('/list-brands', [BrandController::class, 'show'])->name('brand.listbrand');
Route::get('/edit-brand/{id}', [BrandController::class, 'edit'])->name('brand.editbrand');
Route::put('/update-brand/{id}', [BrandController::class, 'update'])->name('brand.update');
Route::delete('/delete-brand/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');
Route::POST('/brands', [BrandController::class, 'create'])->name('brand');
/* Start Catalog Routes */

/* Start distillery Routes */
Route::get('/create-distillery', [DistilleryController::class, 'index'])->name('distillery.createbrand');
Route::get('/list-distillery', [DistilleryController::class, 'show'])->name('distillery.listbrand');
Route::get('/edit-distillery/{id}', [DistilleryController::class, 'edit'])->name('distillery.editbrand');
Route::put('/update-distillery/{id}', [DistilleryController::class, 'update'])->name('distillery.update');
Route::delete('/delete-distillery/{id}', [DistilleryController::class, 'destroy'])->name('distillery.destroy');
Route::POST('/distillery', [DistilleryController::class, 'create'])->name('distillery');
/* Start Catalog Routes */

/* Start Merchant Routes */
Route::get('/create-merchant', [MerchantController::class, 'index'])->name('merchant.createmerchant');
Route::get('/list-merchant', [MerchantController::class, 'show'])->name('merchant.listmerchant');
Route::get('/edit-merchant/{id}', [MerchantController::class, 'edit'])->name('merchant.editmerchant');
Route::put('/update-merchant/{id}', [MerchantController::class, 'update'])->name('merchant.update');
Route::delete('/delete-merchant/{id}', [MerchantController::class, 'destroy'])->name('merchant.destroy');
Route::POST('/merchant', [MerchantController::class, 'create'])->name('merchant');
/* Start Catalog Routes */

/* Start Release Routes */
Route::get('/create-release', [ReleaseController::class, 'index'])->name('release.createrelease');
Route::get('/list-releases', [ReleaseController::class, 'show'])->name('release.listrelease');
Route::get('/edit-release/{id}', [ReleaseController::class, 'edit'])->name('release.editrelease');
Route::put('/update-release/{id}', [ReleaseController::class, 'update'])->name('release.update');
Route::delete('/delete-release/{id}', [ReleaseController::class, 'destroy'])->name('release.destroy');
Route::POST('/releases', [ReleaseController::class, 'create'])->name('release');