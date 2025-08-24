<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function regions(Request $request) {
        
        $region_code = $request->region_code;

        $regions = Region::where('region_code', $region_code)->get();

        return response()->json($regions);
        
    }
    
    public function provinces(Request $request) {
        $region_code = $request->region_code;

        $provinces = Province::where('region_code', $region_code)->get();

        return response()->json($provinces);
        
    }

    public function cities(Request $request) {
        
        $province_code = $request->province_code;

        $cities = City::where('province_code', $province_code)->get();

        return response()->json($cities);

    }   
}
