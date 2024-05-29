<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\ProductCatalog;
use App\Models\Categories;
use App\Models\Companies;
use App\Models\Releases;
use App\Models\States;
use Illuminate\Support\Facades\File;

class ReleaseController extends Controller
{
    public function index()
    {
        $countries=Country::get();
        $productCatalog=ProductCatalog::get();
        return view('release.createrelease',compact('countries','productCatalog'));
    }
    public function create(Request $request)
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
        return redirect('/list-releases')->with('success', 'Release Added successfully.');
    }
    public function show(Releases $productCatalog)
    {
     $releaselist  = ProductCatalog::select('companies.name as company_name', 'categories.name as type_name','releases.other_type as other_type','releases.id as release_id', 'releases.name as release_name', 'releases.story as release_story', 'releases.publication_date as publication_date', 'releases.logo as release_logo')->join('categories', 'categories.company_id', '=', 'companies.id')
     ->join('releases', 'releases.category_id', '=', 'categories.id')
      ->orderBy('releases.id', 'DESC')
     ->paginate(10);
     $D_Merchant= array();

     return view('release.listrelease',compact('releaselist','D_Merchant'));
 }
 public function edit(Request $request, $id)
 {
    $editreleases=Releases::find($id);
    $countries=Country::get();
    $productCatalog=ProductCatalog::get();
    $states=States::where('country_id',$editreleases['country'])->get();
    $other_types = Categories::where("type", $editreleases['other_type'])->get();
    //$other_types  = Categories::join('releases', 'releases.category_id', '=', 'categories.id')->get(['releases.other_type as other_type', 'releases.category_id as category_id','categories.name as type_name']);
    return view('release.editrelease', compact('editreleases','countries','productCatalog','states','other_types'));
}
public function update(Request $request, $id)
{
    $request->validate([
       'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:150'],
            'publication_date'=>['required'],
            'country'=>['required'],
            'region'=>['required'],
            'both_D_M'=>['required'],
            /*'releaselogo'=>['required'],
            'gallery'=>['required'],
            'releasecover'=>['required'],*/
    ]);
    $categories_update = Releases::find($id);
    $categories_update->name = $request->input('name');
    if($request->hasfile('releaselogo')){
        $destination = public_path().'/images/'.$categories_update->releaselogo;
        if(File::exists($destination))
        {
            File::delete($destination);
        }
        $releaselogo = $request->file('releaselogo'); 
        $releaseName = time().'_'.$releaselogo->getClientOriginalName();
        $path = public_path().'/images/';
        $releaselogo->move($path, $releaseName);
        $categories_update->logo = $releaseName;
    }

    if($request->hasfile('gallery')){
        $destination = public_path().'/images/'.$categories_update->gallery;
        if(File::exists($destination))
        {
            File::delete($destination);
        }
        $gallery = $request->file('gallery'); 
        $galleryName = time().'_'.$gallery->getClientOriginalName();
        $path = public_path().'/images/';
        $gallery->move($path, $galleryName);
        $categories_update->gallery = $galleryName;
    }

    if($request->hasfile('releasecover')){
        $destination = public_path().'/images/'.$categories_update->releasecover;
        if(File::exists($destination))
        {
            File::delete($destination);
        }
        $releasecover = $request->file('releasecover'); 
        $releasecoverName = time().'_'.$releasecover->getClientOriginalName();
        $path = public_path().'/images/';
        $releasecover->move($path, $releasecoverName);
        $categories_update->cover = $releasecoverName;
    }
    $categories_update->story = $request->input('description');
    $categories_update->publication_date = $request->input('publication_date');
    $categories_update->country = $request->input('country');
    $categories_update->region = $request->input('region');
    $categories_update->abv = $request->input('abv');
    $categories_update->ean = $request->input('ean');
     $categories_update->price_band = $request->input('price_band');
    $categories_update->other_type = $request->input('other_option')?$request->input('other_option'):'';
    $categories_update->category_id = $request->input('both_D_M')?$request->input('both_D_M'):'';
    $categories_update->update();
    return redirect('/list-releases')->with('success', 'Release Updated successfully.');
}
public function destroy(Request $request,$id)
{
    $delete_catalog_records = Releases::find($id);
    $delete_catalog_records->delete();
    return redirect('/list-releases')->with('success', 'Release deleted successfully.');
}
/*Fetch state*/
public function fetchmerchant_distillery(Request $request){
    $data['data'] = Categories::where("type", $request->id)->get();
    return response()->json($data);
}
/*End of Fetch State*/

}
