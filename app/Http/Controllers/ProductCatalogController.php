<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\States;
use Illuminate\Support\Str;

class ProductCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries=Country::get();
        return view('company.createcompany',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . ProductCatalog::class],
            'country'=>['required'],
            'region'=>['required'],
            'establishment'=>['required'],
            'representative_name'=>['required'],
            'person_name'=>['required'],
            'companylogo'=>['required']
        ]);
        $files = $request->file('companylogo'); 
        if($request->hasfile('companylogo')){
            $fileName = time().'_'.$files->getClientOriginalName();
            $path = public_path().'/images/';
            $files->move($path, $fileName);
        }
        $usercreated= ProductCatalog::create([
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'email' => $_POST['email'],
            'establishment'=>$_POST['establishment'],
            'region'=>$_POST['region'],
            'representative_name'=>$_POST['representative_name'],
            'representative_contact'=>$_POST['representative_contact'],
            'person_name'=>$_POST['person_name'],
            'person_info'=>$_POST['person_info'],
            'logo' => $fileName?$fileName:'',
            'country_id' => $_POST['country'],
            'company_social'=>$_POST['medialink'],
        ]);
        return redirect('/list-company')->with('success', 'Product Catalog record Added successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCatalog  $productCatalog
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCatalog $productCatalog)
    {
        $product=ProductCatalog::orderBy('id', 'DESC')->paginate(10);
        return view('company.listcompany',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCatalog  $productCatalog
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $editproductCatalog=ProductCatalog::find($id);
        $countries=Country::get();
        $states=States::where('country_id',$editproductCatalog['country_id'])->get();
        return view('company.editcompany', compact('editproductCatalog','countries','states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCatalog  $productCatalog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:150'],
            'country_id'=>['required'],
            'region'=>['required'],
            'establishment'=>['required'],
            'representative_name'=>['required'],
            'person_name'=>['required']
        ]);
        $files = $request->file('logo'); 
        $product_update = ProductCatalog::find($id);
        $product_update->name = $request->input('name');
        $product_update->description = $request->input('description');
        $product_update->country_id = $request->input('country_id');
        $product_update->establishment = $request->input('establishment');
        $product_update->region = $request->input('region');
        $product_update->representative_name = $request->input('representative_name');
        $product_update->representative_contact = $request->input('representative_contact');
        $product_update->person_name = $request->input('person_name');
        $product_update->person_info = $request->input('person_info');
        $product_update->company_social = $request->input('medialink');
        if($request->hasfile('logo')){
            $destination = public_path().'/images/'.$product_update->logo;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $fileName = time().'_'.$files->getClientOriginalName();
            $path = public_path().'/images/';
            $files->move($path, $fileName);
            $product_update->logo=$fileName;
        }
        
        $product_update->update();
        return redirect('/list-company')->with('success', 'Product Catalog record Added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCatalog  $productCatalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $delete_catalog_records = ProductCatalog::find($id);
        $delete_catalog_records->delete();
        return redirect('/list-company')->with('success', 'Catalog record deleted successfully.');
    }

    /*Fetch state*/
    public function fetchState(Request $request){
        $data['states'] = States::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }
    /*End of Fetch State*/
}
