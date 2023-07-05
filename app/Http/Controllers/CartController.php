<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Models\Features\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiHelpers;


    public function userIndex(Request $request)
    {

        $user = $request->user();
        $activeCart = $user->activeCart();

        if (!$activeCart->first()) {
            $activeCart = $this->createNewActiveCart($user);
        }

        $itemList = $activeCart->with('itemList.entity')->first();

        return $this->onSuccess(['cart' => $itemList], "Successfully Fetch Cart Detail");
    }

    public function createNewActiveCart($user)
    {
        return $user->activeCart()->create();
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'item.id' => 'required|uuid|exists:entities,id',
            'item.name' => 'required'
        ]);

        $id = collect($validated)->mapWithKeys(function ($a) {
            return $a;
        })->only('id')->implode("");

        $succeed = $request->user()->activeCart->addToCart($id);

        return $this->onSuccess($succeed->makeVisible('cart_id'), 'Item Added to Cart');
    }

    public function updateCart(Request $request) {
        
        if(!$request->action == "updateQuantity"){
            return $this->fail(400,"Invalid Action");
        }

        $validated = $request->validate(['data.id' => 'uuid']);
        
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
