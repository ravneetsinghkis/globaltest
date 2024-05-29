<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ProductCatalog;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ReleaseController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::POST('create-brand', [BrandController::class, 'create_brand']);
    Route::get('all-brands', [BrandController::class, 'all_brands']);
    Route::get('all-brands/company/{id}', [BrandController::class, 'all_brands_company']);
    Route::get('view-brand/{id}', [BrandController::class, 'view_brand']);
    Route::put('edit-brand', [BrandController::class, 'updatebrand']);
    Route::delete('delete-brands/{id}', [BrandController::class, 'deletebrand']);

    /*Country and State Api*/
    Route::get('all-country', [BrandController::class, 'all_country']);
    Route::get('all-state/{id}', [BrandController::class, 'all_states']);
    /*End of Country State Api*/

      /*Merchant and Distillery*/
      Route::get('all-merchant-distillery', [BrandController::class, 'all_mer_distillery']);
      Route::get('all-members/{id}', [BrandController::class, 'all_member']);
      /*End of Merchant and Distillery*/
      Route::post('create-release', [ReleaseController::class, 'create']);
      Route::get('all-releases', [ReleaseController::class, 'all_releases']);
      Route::get('all-release-distillery', [ReleaseController::class, 'all_release_distillery']);
      Route::get('all-release-merchants', [ReleaseController::class, 'all_release_merchants']);
      Route::get('all-release-brands', [ReleaseController::class, 'all_release_brands']);
      Route::POST('edit-release/{id}', [ReleaseController::class, 'edit_release']);

      /*Edit Release Merchant/Distillery/Brands/Company*/
      Route::get('all-release-distillery/{id}', [ReleaseController::class, 'single_release_distillery']);
      Route::get('all-release-merchants/{id}', [ReleaseController::class, 'single_release_merchants']);
      Route::get('all-release-brands/{id}', [ReleaseController::class, 'single_release_brands']);
      Route::get('all-release-companies/{id}', [ReleaseController::class, 'single_release_companies']);

      /*Get Specific Companies Distillery*/
      Route::get('companies-distilleries/{id}', [ReleaseController::class, 'get_companies_distilleries']);
      /*End of specific Companies Distillery*/
});
