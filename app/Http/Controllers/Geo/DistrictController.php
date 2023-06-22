<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Requests\Geo\DistrictRequest;
use App\Models\Geo\City;
use App\Models\Geo\District;
use App\Models\Geo\Province;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    use ApiHelpers;

    function __construct(City $city)
    {
        if(!$city->province()){
            return $this->fail(404,'Not Found');  
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Province $province, City $city)
    {
        // if(!$city->province()){
        //     return $this->fail(404,'Not Found');  
        // }
        if(!$districts = $city->districts()->get()){
            return $this->fail(404,'Not Found');  
        }
        return $this->onSuccess($districts,'success',200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(DistrictRequest $request,string $province, City $city)
    {
        if (!$district = $city->district()->create($request->validated())){
            return $this->fail(404,'Some Error');
        };
        
        return $this->onSuccess($district,'added');
    }

    /**
     * Display the specified resource.
     */
    // public function show(District $district)
    // {
        //
    // }

        /**
     * Update the specified resource in storage.
     */
    public function update(DistrictRequest $request, string $province ,string $city,District $district)
    {
        if(!$distric = $district->city()){
            return $this->fail(404,'Not Found');  
        }
        $patchedDistrict = $district->update($request->validated());
        return $this->onSuccess($patchedDistrict,'Updated',200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(District $district, string $province,string $city)
    {
        if(!$distric = $district->city() || $district->delete()){
            return $this->fail(404,'Not Found');  
        }
        return $this->succeed(200,"deleted");
    }
}
