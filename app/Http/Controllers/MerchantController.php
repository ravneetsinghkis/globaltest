<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\ProductCatalog;
use App\Models\Categories;
use App\Models\States;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    public function index()
    {
        $countries=Country::get();
        $productCatalog=ProductCatalog::get();
        return view('merchant.createmerchant',compact('countries','productCatalog'));
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
            'region'=> $_POST['region'],
            'company_id' => $_POST['company'],
            'type'=>'Merchant',
            'other_type'=>'',
            'brand_DM'=>'',
            'logo' => $brandName,
            'cover' => $brandcoverName,
            'socialmedia_link' => $_POST['brandmedialink'],
        ]);
        return redirect('/list-merchant')->with('success', 'Product Catalog record Added successfully.');
    }
    public function show(Categories $productCatalog)
    {
        if(isset($_GET['company_id'])){
            $company_id=$_GET['company_id'];
            $merchantlist = Categories::select('categories.id as merchant_id','categories.name as merchant_name', 'categories.story as merchant_story', 'categories.establishment as merchant_establishment', 'categories.logo as merchant_logo','companies.name as company_name')->join('companies', 'companies.id', '=', 'categories.company_id')->where('categories.type','Merchant')->where('companies.id',$company_id)->orderBy('categories.id', 'DESC')->paginate(10);
        }else{
            $merchantlist = Categories::select('categories.id as merchant_id','categories.name as merchant_name', 'categories.story as merchant_story', 'categories.establishment as merchant_establishment', 'categories.logo as merchant_logo','companies.name as company_name')->join('companies', 'companies.id', '=', 'categories.company_id')->where('categories.type','Merchant')->orderBy('categories.id', 'DESC')->paginate(10);
        }
        return view('merchant.listmerchant',compact('merchantlist'));
    }
    public function edit(Request $request, $id)
    {
        $editbrands=Categories::find($id);
        $countries=Country::get();
        $productCatalog=ProductCatalog::get();
        $states=States::where('country_id',$editbrands['country'])->get();
        return view('merchant.editmerchant', compact('editbrands','countries','productCatalog','states'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:150'],
            'establishment'=>['required'],
            'country_id'=>['required'],
            'region'=>['required']
        ]);
        $categories_update = categories::find($id);
        $categories_update->name = $request->input('name');
        if($request->hasfile('logo')){
            $destination = public_path().'/images/'.$categories_update->logo;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $brandlogo = $request->file('logo'); 
            $brandName = time().'_'.$brandlogo->getClientOriginalName();
            $path = public_path().'/images/';
            $brandlogo->move($path, $brandName);
            $categories_update->logo = $brandName;
        }

        if($request->hasfile('cover')){
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
        $categories_update->story = $request->input('description');
        $categories_update->establishment = $request->input('establishment');
        $categories_update->company_id  = $request->input('company');
        $categories_update->country = $request->input('country_id');
        $categories_update->update();
        return redirect('/list-merchant')->with('success', 'Product Catalog record Added successfully.');
    }
    public function destroy(Request $request,$id)
    {
        $delete_catalog_records = Categories::find($id);
        $delete_catalog_records->delete();
        return redirect('/list-merchant')->with('success', 'Catalog record deleted successfully.');
    }

}
