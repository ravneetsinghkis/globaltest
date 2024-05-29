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


class CompanyController extends Controller
{
    public function companylist(Request $request)
    {
        $companylist=ProductCatalog::get();
        if ($companylist) {
            return response()->json([
                'status' => 'success',
                'message' => 'List of company name',
                'data' => $companylist
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
                'data' => $companylist
            ], 401);
        }
    }
    
}
