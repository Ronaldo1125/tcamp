<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use App\Models\Barangay;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HttpLocationController extends Controller
{
    public function __invoke(Request $request)
    {
        
    }

    public function index()
    {
     
    }

    public function getRegions()
    {
        //$response = Http::get('https://openstat.psa.gov.ph:443/PXWeb/sq/dcb4be53-94f8-49f7-a7d3-ef42397ab728');
        //$population = json_decode($response);
        //dd($population);
        $response = Http::get('https://ph-locations-api.buonzz.com/v1/regions');

        $regions = json_decode($response->body());
        
        foreach ($regions->data as $r) {
            $region = new Region();
            $region->name = $r->name;
            $region->region_code = $r->id;
            $region->lodging_cost = 1500;
            $region->meals_cost = 150;
            $region->incidental_expenses_cost = 300;
            $region->save();
        }

        return "Regions data successfully added to the Database!";
    }

    public function getProvinces()
    {    
        $response = Http::get('https://ph-locations-api.buonzz.com/v1/provinces');

        $provinces = json_decode($response->body());
        
        foreach ($provinces->data as $r) {
            $province = new Province();
            $province->name = $r->name;
            $province->province_code = $r->id;
            $province->region_code = $r->region_code;
            $province->save();

        }

        return "Provinces data successfully added to the Database!";

    }

    public function getCities(Request $request) 
    {


        // return response()->json([
        //     'name' => 'Abigail',
        //     'state' => 'CA',
        // ]);
        $response = Http::get('https://ph-locations-api.buonzz.com/v1/cities?page=2');

        $cities = json_decode($response->body());
        
        foreach ($cities->data as $r) {
            $city = new City();
            $city->name = $r->name;
            $city->city_code = $r->id;
            $city->province_code = $r->province_code;
            $city->region_code = $r->region_code;
            $city->save();

            echo $r->name . "-- Added to the Database <br/>";
        }

        return "Citiess data successfully added to the Database!";

        
    }

    public function getBarangays()
    {
        $barangays = Http::get('https://ph-locations-api.buonzz.com/v1/barangays?page=40')->object();

        //dd($barangays);

        foreach ($barangays->data as $r) {
            $barangay = new Barangay();
            $barangay->name = $r->name;
            $barangay->barangay_code = $r->id;
            $barangay->city_code = $r->city_code;
            $barangay->province_code = $r->province_code;
            $barangay->region_code = $r->region_code;
            $barangay->save();

            echo $r->name . "-- Added to the Database <br/>";
        }

        return "Barangays data successfully added to the Database!";

        
    }
}
