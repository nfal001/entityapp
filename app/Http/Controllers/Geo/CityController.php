<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Geo\CityRequest;
use App\Models\Geo\City;
use Illuminate\Http\Request;

class CityController extends Controller
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
    public function store(CityRequest $request)
    {
        //
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
    public function update(CityRequest $request, string $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $city)
    {
        //
    }
}
