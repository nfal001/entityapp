<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Geo\DistrictRequest;
use App\Models\Geo\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(DistrictRequest $request)
    {
        //
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
    public function update(DistrictRequest $request, string $city)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $district)
    {
        //
    }
}
