<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCatalog;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use App\Models\Country;
use App\Models\Releases;
use App\Models\Categories;
use App\Models\States;
use Illuminate\Support\Facades\File;

class ReleaseController extends Controller
{
    
    public function create_release(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:150'],
            'publication_date'=>['required'],
            'country'=>['required'],
            'region'=>['required'],
            'both_D_M'=>['required'],
            'releaselogo'=>['required'],
            'gallery'=>['required'],
            'releasecover'=>['required'],
        ]);
        /*Brand Logo image upload*/
        $releaselogo = $request->file('releaselogo'); 
        $releaseName = time().'_'.$releaselogo->getClientOriginalName();
        $path = public_path().'/images/';
        $releaselogo->move($path, $releaseName);
        /*End of Brand Logo image upload*/

        /*Brand Logo image upload*/
        $gallery = $request->file('gallery'); 
        $galleryName = time().'_'.$gallery->getClientOriginalName();
        $path = public_path().'/images/';
        $gallery->move($path, $galleryName);
        /*End of Brand Logo image upload*/

        /*Brand Cover image upload*/
        $releasecover = $request->file('releasecover'); 
        $releasecoverName = time().'_'.$releasecover->getClientOriginalName();
        $path = public_path().'/images/';
        $releasecover->move($path, $releasecoverName);
        /*Brand Cover image upload*/

        $usercreated= Releases::create([
            'name' => $_POST['name'],
            'story' => $_POST['description'],
            'ean' => $_POST['ean'],
            'publication_date' => $_POST['publication_date'],
            'country' => $_POST['country'],
            'region' => $_POST['region'],
            'category_id' => $_POST['both_D_M'],
            'type'=>'Release',
            'other_type'=>$_POST['other_option'],
            'release_DM'=>$_POST['both_D_M'],
            'abv'=>$_POST['abv'],
            'price_band'=>$_POST['price_band'],
            'logo' => $releaseName,
            'gallery' => $galleryName,
            'cover' => $releasecoverName,
            'socialmedia_link' => $_POST['releasemedialink'],
        ]);
        if($usercreated){
            return response()->json([
                'status' => 'success',
                'message' => 'New Release has been created successfully',
            ], 200);
        }else{

        }
    }
    public function all_releases(Request $request)
    {
         $productCatalog=ProductCatalog::get();
        $releaselist  = ProductCatalog::join('categories', 'categories.company_id', '=', 'companies.id')
     ->join('releases', 'releases.category_id', '=', 'categories.id')
     ->get(['companies.name as company_name', 'categories.name as type_name','releases.other_type as other_type','releases.id as release_id', 'releases.name as release_name', 'releases.story as release_story', 'releases.publication_date as publication_date', 'releases.logo as release_logo']);
        if (!empty($releaselist)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Release Listing',
                'data' => $releaselist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
                'data' => $releaselist
            ], 401);
        }
    }
    public function view_brand(Request $request, $id)
    {
        $brand_info = array();
        $brands=Categories::where('type','Brand')->where('id',$id)->first();
        $countries=Country::where('id',$brands['country'])->first();
        $states=States::where('id',$brands['region'])->first();
        $country_id=$countries['id'];
        $country_name=$countries['name'];
        $productCatalog=ProductCatalog::where('id',$brands['company_id'])->first();
        $brand_info['id'] = $brands['id'];
        $brand_info['name'] = $brands ['name'];
        $brand_info['type'] = $brands ['type'];
        $brand_info['is_selected'] = $brands ['is_selected'];
        $brand_info['other_type'] = $brands ['other_type'];
        $brand_info['brand_DM'] = $brands ['brand_DM'];
        $brand_info['establishment'] = $brands ['establishment'];
        $brand_info['story'] = $brands ['story'];
        $brand_info['logo'] = $brands ['logo'];
        $brand_info['cover'] = $brands ['cover'];
        $brand_info['socialmedia_link'] = $brands ['socialmedia_link'];
        $brand_info['country_id'] = $country_id;
        $brand_info['country_name'] = $country_name;
        $brand_info['state_id'] = $states['id'];
        $brand_info['state_name'] = $states['name'];
        $brand_info['companyname']=$productCatalog['name'];
        $brand_info['companylist']=$productCatalog;
        if(!empty($brand_info)) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of brands name',
                'data' => $brand_info
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
    public function updatebrand(Request $request)
    {
        $brands=Categories::where('type','Brand')->get();
        if ($brands) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of brands name',
                'data' => $brands
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
                'data' => $brands
            ], 401);
        }
    }
    public function deletebrand(Request $request, $id)
    {
        $delete_catalog_records = Categories::find($id);
        if (!empty($delete_catalog_records)) {
            $record_deleted=$delete_catalog_records->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Brand deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
  
    
    public function all_release_distillery(Request $request){
        $merchantlist= Releases::where('other_type','=','Distillery')->get();
         if (!$merchantlist->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Distillery Releases',
                'data' => $merchantlist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
    
    public function all_release_merchants(Request $request){
        $merchantlist=Releases::where('other_type','=','Merchant')->get();
         if (!$merchantlist->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Merchant Releases',
                'data' => $merchantlist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }

    public function all_release_brands(Request $request){
        $merchantlist=Releases::where('other_type','=','Brand')->get();
       if (!$merchantlist->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Brands Releases',
                'data' => $merchantlist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No Release found',
            ], 401);
        }
    }

    public function all_brands_company(Request $request,$id){
        $companies=ProductCatalog::where('id',$id)->first();
        $merchantlist=Categories::where('type','=','Brand')->where('company_id','=',$companies['id'])->get();
        $companies_details=array();
        $companies_details['company_id'] = $companies['id'];
        $companies_details['company_name'] = $companies['name'];
        $companies_details['company_description'] = $companies ['description'];
        $companies_details['company_email'] = $companies ['email'];
        $companies_details['company_establishment'] = $companies ['establishment'];
        $companies_details['company_logo'] = $companies ['logo'];
        
        foreach($merchantlist as $key=>$merchant){
            $companies_details['company_brands'][$key]['brand_id']=$merchant['id'];
            $companies_details['company_brands'][$key]['brand_name']=$merchant['name'];
            $companies_details['company_brands'][$key]['brand_story']=$merchant['story'];
            $companies_details['company_brands'][$key]['brand_logo']=$merchant['logo'];
        }
        
            return response()->json([
                'status' => 'success',
                'message' => 'List of Companies with Brands',
                'data' => $companies_details
            ], 200);
    }
    public function edit_release(Request $request,$id){
        $release_update = Releases::find($id);
        $release_update->name = $request->input('name');
        $release_updates=$release_update->update();
        if($release_updates){
            return response()->json([
                'status' => 'success',
                'message' => 'Relase title is updated successfully',
                'data' => $release_update
            ], 200);
        }
    }
    public function single_release_distillery(Request $request,$id){
        $distilleryReleaselist= Releases::where('other_type','=','Distillery')->where('category_id','=',$id)->get();
         if (!$distilleryReleaselist->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Distillery Releases',
                'data' => $distilleryReleaselist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
    public function single_release_merchants(Request $request,$id){
        $distilleryReleaselist= Releases::where('other_type','=','Merchant')->where('category_id','=',$id)->get();
         if (!$distilleryReleaselist->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Merchant Releases',
                'data' => $distilleryReleaselist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
    public function single_release_brands(Request $request,$id){
        $BrandReleaselist= Releases::where('other_type','=','Brand')->where('category_id','=',$id)->get();
         if (!$BrandReleaselist->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Brands Releases',
                'data' => $BrandReleaselist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
    public function single_release_companies(Request $request,$id){
        $releaselist  = ProductCatalog::join('categories', 'categories.company_id', '=', 'companies.id')
        ->join('releases', 'releases.category_id', '=', 'categories.id')
        ->where('companies.id','=',$id)
        ->get(['companies.name as company_name', 'categories.name as type_name','releases.other_type as other_type','releases.id as release_id', 'releases.name as release_name', 'releases.story as release_story', 'releases.publication_date as publication_date', 'releases.logo as release_logo']);
    
        if (!$releaselist->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Country Releases',
                'data' => $releaselist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
    public function get_companies_distilleries(Request $request,$id){
        $get_companies_distilleries  = Categories::where([['type', '=', 'Distillery'],
        ['company_id', '=', $id]])->get();
        if (!$get_companies_distilleries->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Company Distilllery',
                'data' => $get_companies_distilleries
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
}
