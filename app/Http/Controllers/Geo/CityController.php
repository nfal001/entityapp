<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Requests\Geo\CityRequest;
use App\Models\Geo\City;
use App\Models\Geo\Province;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use ApiHelpers;
    /**
     * Display a listing of the resource.
     */
    public function index(Province $province)
    {
        $cities = $province->cities()->get();

        return $this->onSuccess($cities,'Success Fetching Data',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Province $province,CityRequest $request)
    {
        if (!$createCity = $province->city()->create($request->only(['name']))){
            return $this->fail(404,'Unknown Province');  
        }
        return $this->onSuccess($createCity,'City Added',200);
    }

    /**
     * Display the specified resource.
     */
    // public function show(City $city)
    // {
    //     
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, string $province,string $city)
    {
        if(!$city = City::find($city)->update(['name'=>$request->name])){
            return $this->fail(404,'City Not Found');  
        }
        return $this->onSuccess($city,'City Updated',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province,string $city)
    {
        if(!$deletedCity = City::where('province_id',$province)->where('id',$city)->first()->delete()){
            return $this->fail(404,'City Not Found');  
        }
        return $this->onSuccess($city,'City Deleted',200);
    }
}
