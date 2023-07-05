<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Models\Features\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiHelpers;
    public function userIndex(Request $request) {
        // no cart active? create one. else get user active cart
        $user = $request->user();
        if(!$cart = $user->activeCart()->first()){
            $cart = $this->createNewActiveCart($user);
        }
        return $this->onSuccess(['cart'=>$cart],"Successfully Fetch Cart Detail");
        // return $user->activeCart()->first();
    }

    public function createNewActiveCart($user) {
        return $user->activeCart()->create();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
