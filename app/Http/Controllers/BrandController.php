<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\ProductCatalog;
use App\Models\Categories;
use App\Models\States;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index()
    {
        $countries=Country::get();
        $productCatalog=ProductCatalog::get();
        return view('brand.createbrand',compact('countries','productCatalog'));
    }
    public function create(Request $request)
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
        /*Gallery Images*/
        $galleryimages = [];
        if ($request->brandgallery) {
            foreach ($request->brandgallery as $key => $image) {
                $GalleryName = time() . rand(1, 99) . '.' . $image->extension();
                $image->move(public_path('images'), $GalleryName);
                $galleryimages[] = $GalleryName;
            }
        }
        /*End of Gallery*/
        $usercreated= Categories::create([
            'name' => $_POST['name'],
            'story' => $_POST['description'],
            'establishment' => $_POST['establishment'],
            'country' => $_POST['country'],
            'region' => $_POST['region'],
            'company_id' => $_POST['company'],
            'type'=>'Brand',
            'is_selected'=>isset($_POST['is_selected'])?$_POST['is_selected']:'0',
            'other_type'=>$_POST['other_option'],
            'brand_DM'=>$_POST['both_D_M'],
            'logo' => $brandName,
            'cover' => $brandcoverName,
            'gallery'=>json_encode($galleryimages) ? json_encode($galleryimages) : "[]",
            'socialmedia_link' => $_POST['brandmedialink'],
        ]);
        return redirect('/list-brands')->with('success', 'Product Catalog record Added successfully.');
    }
    public function show(Categories $productCatalog)
    {
        // $brandlist=Categories::where('type','Brand')->get();
        // return view('brand.listbrand',compact('brandlist'));
        if(isset($_GET['company_id'])){
            $company_id=$_GET['company_id'];
            $brandlist = Categories::select('categories.id as brand_id','categories.name as brand_name', 'categories.story as brand_story', 'categories.establishment as brand_establishment', 'categories.logo as brand_logo','categories.other_type as other_type','categories.brand_DM as brand_DM','companies.name as company_name')->join('companies', 'companies.id', '=', 'categories.company_id')->where('categories.type','Brand')->where('companies.id',$company_id)->orderBy('categories.id', 'DESC')->paginate(10);  
        }
        else if(isset($_GET['distillery_id'])){
            $ditillery_id=$_GET['distillery_id'];
            $brandlist = Categories::select('categories.id as brand_id','categories.name as brand_name', 'categories.story as brand_story', 'categories.establishment as brand_establishment', 'categories.logo as brand_logo','categories.other_type as other_type','categories.brand_DM as brand_DM','companies.name as company_name')->join('companies', 'companies.id', '=', 'categories.company_id')->where('categories.type','Brand')->where('categories.brand_DM',$ditillery_id)->orderBy('categories.id', 'DESC')->paginate(10);
        }
        else if(isset($_GET['merchant_id'])){
            $merchant_id=$_GET['merchant_id'];
            $brandlist = Categories::select('categories.id as brand_id','categories.name as brand_name', 'categories.story as brand_story', 'categories.establishment as brand_establishment', 'categories.logo as brand_logo','categories.other_type as other_type','categories.brand_DM as brand_DM','companies.name as company_name')->join('companies', 'companies.id', '=', 'categories.company_id')->where('categories.type','Brand')->where('categories.brand_DM',$merchant_id)->orderBy('categories.id', 'DESC')->paginate(10);
        }
        else{
            $brandlist = Categories::select('categories.id as brand_id','categories.name as brand_name', 'categories.story as brand_story', 'categories.establishment as brand_establishment', 'categories.logo as brand_logo','categories.other_type as other_type','categories.brand_DM as brand_DM','companies.name as company_name')->join('companies', 'companies.id', '=', 'categories.company_id')->where('categories.type','Brand')->orderBy('categories.id', 'DESC')->paginate(10);
        }
        $D_Merchant=array();
        foreach ($brandlist as $brand) {
            $dm = Categories::select('categories.name as dm_name', 'categories.type as dm_type', 'categories.id as dm_id')->where('id', $brand['brand_DM'])->get();  
            foreach ($dm as $key=>$m) {
                $D_Merchant['data'][$key]['dm_name'][] = $m['dm_name'];
                $D_Merchant['data'][$key]['dm_type'][] = $m['dm_type'];
                $D_Merchant['data'][$key]['dm_id'][] = $m['dm_id'];
            }
        }
         return view('brand.listbrand',compact('brandlist','D_Merchant'));
    }
    public function edit(Request $request, $id)
    {
        $editbrands=Categories::find($id);
        $countries=Country::get();
        $productCatalog=ProductCatalog::get();
        $states=States::where('country_id',$editbrands['country'])->get();
        $other_types = Categories::where("type", $editbrands['other_type'])->get();
        return view('brand.editbrand', compact('editbrands','countries','productCatalog','states','other_types'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:150'],
            'establishment'=>['required'],
            'country_id'=>['required'],
            'region'=>['required'],
            'company'=>['required']
        ]);
        $categories_update = Categories::find($id);
        $categories_update->name = $request->input('name');
        if($request->hasfile('brandlogo')){
            $destination = public_path().'/images/'.$categories_update->logo;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $brandlogo = $request->file('brandlogo'); 
            $brandName = time().'_'.$brandlogo->getClientOriginalName();
            $path = public_path().'/images/';
            $brandlogo->move($path, $brandName);
            $categories_update->logo = $brandName;
        }

        if($request->hasfile('brandcover')){
            $destination = public_path().'/images/'.$categories_update->cover;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $brandcover = $request->file('brandcover'); 
            $brandcoverName = time().'_'.$brandcover->getClientOriginalName();
            $path = public_path().'/images/';
            $brandcover->move($path, $brandcoverName);
            $categories_update->cover = $brandcoverName;
        }
         /*Gallery Images*/
         $galleryimages = [];
         if ($request->brandgallery) {
             foreach ($request->brandgallery as $key => $image) {
                 $GalleryName = time() . rand(1, 99) . '.' . $image->extension();
                 $image->move(public_path('images'), $GalleryName);
                 $galleryimages[] = $GalleryName;
             }
         }
         /*End of Gallery*/
        $categories_update->story = $request->input('description');
        $categories_update->establishment = $request->input('establishment');
        $categories_update->company_id  = $request->input('company');
        $categories_update->country = $request->input('country_id');
        $categories_update->region = $request->input('region');
        $categories_update->is_selected=isset($_POST['is_selected'])?$_POST['is_selected']:'0';
        $categories_update->other_type = $request->input('other_option')?$request->input('other_option'):'';
        $categories_update->brand_DM = $request->input('both_D_M')?$request->input('both_D_M'):'';
        $categories_update->gallery=json_encode($galleryimages) ? json_encode($galleryimages) : "[]";
        $categories_update->update();
        return redirect('/list-brands')->with('success', 'Product Catalog record Added successfully.');
    }
    public function destroy(Request $request,$id)
    {
        $delete_catalog_records = Categories::find($id);
        $delete_catalog_records->delete();
        return redirect('/list-brands')->with('success', 'Catalog record deleted successfully.');
    }
     /*Fetch state*/
     public function fetchmerchant_distillery(Request $request){
        $data['data'] = Categories::where("type", $request->id)->get();
        return response()->json($data);
    }
    /*End of Fetch State*/

}
