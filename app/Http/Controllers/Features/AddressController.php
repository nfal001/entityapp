<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Models\Features\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ApiHelpers;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = User::find(auth()->user()->id)->addresses()->get();
        return $this->onSuccess($addresses,'Success Fetch Address',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        //
    }
}
