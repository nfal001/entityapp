<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Requests\Features\AddressRequest;
use App\Models\Features\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function selectAddress(Request $request, Address $address)
    {
        $user = $request->user();

        if($address->is_choosen_address){
            return $this->onSuccess($address,"Address Selected");
        }
        
        if($address->user->id !== $user->id){
            return $this->fail(422,"Address not belong to user");
        }

        DB::beginTransaction();
        
        try {
            
            $activeAddr = Address::findOrFail($user->choosenAddress->id);
            
            if($activeAddr){
                $activeAddr->is_choosen_address = 0;
                $activeAddr->save();
            }

            $address->is_choosen_address = 1;
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $th;
            return $this->fail(500,"Something Went Error");
        }

        $address->save();
        return $this->onSuccess($address,"Address Selected");
    }

    public function show(Address $address) {
        $loadedAddress = $address->load(['province:id,name','city:id,name','district:id,name']);
        return $this->onSuccess($loadedAddress,"Successfully Fetch Address ID : $address->id");
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
