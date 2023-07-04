<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Requests\Features\AddressRequest;
use App\Models\Features\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use ApiHelpers;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->get();
        
        return $this->onSuccess($addresses,'Success Fetch Address',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        $validated = $request->safe()->except('some');

        $request->user()->address()->create($validated);

        return $this->succeed(200,"Succesfully Add new Address");
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
        if(!$address->user_info_id == auth()->user()->id){
            return $this->fail(401,"Address Does not Belong to user");
        }

        $address->delete();
        return $this->succeed(200,"Address Deleted");
    }
}
