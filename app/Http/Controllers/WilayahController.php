<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class WilayahController extends Controller
{
    public function provinces()
    {
        return Province::get();
    }

    public function cities(Request $request, $id)
    {
        $city = City::where('province_code',$id);

        if ($city) {
            $data = $city->pluck('name', 'code');
            return response()->json($data);
        }

        return response()->json(['message' => 'City not found'], 404);
    }

    public function districts(Request $request, $id)
    {
        $district = District::where('city_code',$id);

        if ($district) {
            $data = $district->pluck('name', 'code');
            return response()->json($data);
        }

        return response()->json(['message' => 'Distirct not found'], 404);
    }

    public function villages(Request $request, $id)
    {
        $villages = Village::where('district_code',$id);

        if ($villages) {
            $data = $villages->pluck('name', 'code');
            return response()->json($data);
        }

        return response()->json(['message' => 'District not found'], 404);
    }
}
