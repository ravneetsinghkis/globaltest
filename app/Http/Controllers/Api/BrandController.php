<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCatalog;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use App\Models\Country;
use App\Models\Categories;
use App\Models\States;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    
    public function create_brand(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:150'],
            'establishment'=>['required'],
            'country'=>['required'],
            'region'=>['required'],
            'company'=>['required'],
            'brandlogo'=>['required'],
            'brandcover'=>['required'],
        ]);
        /*Brand Logo image upload*/
        $brandlogo = $request->file('brandlogo'); 
        $brandName = time().'_'.$brandlogo->getClientOriginalName();
        $path = public_path().'/images/';
        $brandlogo->move($path, $brandName);
        /*End of Brand Logo image upload*/

        /*Brand Cover image upload*/
        $brandcover = $request->file('brandcover'); 
        $brandcoverName = time().'_'.$brandcover->getClientOriginalName();
        $path = public_path().'/images/';
        $brandcover->move($path, $brandcoverName);
         /*Brand Cover image upload*/
       
        $usercreated= Categories::create([
            'name' => $_POST['name'],
            'story' => $_POST['description'],
            'establishment' => $_POST['establishment'],
            'country' => $_POST['country'],
            'region' => $_POST['region'],
            'company_id' => $_POST['company'],
            'type'=>'Brand',
            'is_selected'=>isset($_POST['is_selected'])?$_POST['is_selected']:'0',
            'other_type'=>isset($_POST['other_option'])?$_POST['other_option']:'',
            'brand_DM'=>isset($_POST['both_D_M'])?$_POST['both_D_M']:'',
            'logo' => $brandName,
            'cover' => $brandcoverName,
            'socialmedia_link' => $_POST['brandmedialink'],
        ]);
        if($usercreated){
            return response()->json([
                'status' => 'success',
                'message' => 'New Brand has been created successfully',
            ], 200);
        }else{

        }
    }
    public function all_brands(Request $request)
    {
        $brands=Categories::where('type','Brand')->get();
        if (!empty($brands)) {
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
    public function all_country(){
        $all_country=Country::all();
        if (!empty($all_country)) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Countries',
                'data' => $all_country
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
    public function all_states(Request $request, $id){
        $all_states=States::where('country_id',$id)->get();
        if (!empty($all_states)) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of States',
                'data' => $all_states
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
    public function all_mer_distillery(Request $request){
        $merchantlist=Categories::where('type','=','Merchant')->orWhere('type','=','Distillery')->get();
        if (!empty($merchantlist)) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of Merchant and Distillery',
                'data' => $merchantlist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
            ], 401);
        }
    }
    public function all_member(Request $request,$id){
        if($id==1){
            $merchantlist=Categories::where('type','=','Merchant')->get();
            if (!empty($merchantlist)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'List of Merchants',
                    'data' => $merchantlist
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No data found',
                ], 401);
            }
        }else{
            $Distillerytlist=Categories::where('type','=','Distillery')->get();
            if (!empty($Distillerytlist)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'List of Distilleries',
                    'data' => $Distillerytlist
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No data found',
                ], 401);
            }
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
}
