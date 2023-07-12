<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Requests\Geo\ProvinceRequest;
use App\Models\Geo\Province;

class ProvinceController extends Controller
{
    use ApiHelpers;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::all();
        return $this->onSuccess($provinces,'Success Fetching Province',200); // province class all or paginated
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProvinceRequest $request)
    {
        $province = Province::create(['name'=> $request->name]);
        return $this->onSuccess($province,'Province Added');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Province $province)
    // {
        //
    // }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProvinceRequest $request, Province $province)
    {
        $patchedProvince = $province->update(['name'=> $request->name]);
        return $this->onSuccess($patchedProvince,'Province Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        $province->delete();
        return $this->succeed(200,'Province Deleted');
    }
}
