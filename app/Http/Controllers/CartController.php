<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Models\CartEntity;
use App\Models\Entity;
use App\Models\Features\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiHelpers;


    public function userIndex(Request $request)
    {

        $user = $request->user();

        $oldActiveCart = Cart::with('itemList.entity')->where('user_id',$user->id)->where('status','active');

        // return [$oldActiveCart,$user];
        
        if (!$oldActiveCart->first()) {
            $created = $this->createNewActiveCart($user)->load('itemList.netity');
            $itemList = $created;
        } else {
            $freshActiveCart = $oldActiveCart->first();
            $itemList = $freshActiveCart;
        }


        return $this->onSuccess(['cart' => $itemList], "Successfully Fetch Cart Detail");
    }

    public function createNewActiveCart($user)
    {
        return $user->activeCart()->create();
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'data.id' => 'required|uuid|exists:entities,id',
            'data.name' => 'required',
        ]);

        
        if(!$activeCart = $request->user()->activeCart){
            $activeCart = $this->createNewActiveCart($request->user());
        };

        $id = $validated['data']['id'];

        // return $id;
        
        $entityExistInUserActiveCart = CartEntity::where('entity_id',$id)->where('cart_id',$activeCart->id);
        // return $cart;
        
        $last_price = Entity::find($id)->price;
        
        if($entityExistInUserActiveCart->count() >= 1) {
            return $this->fail(422,"Entity Already Added");
        }
        
        $succeed = $request->user()->activeCart->addToCart($id,$last_price);
        // return '1';

        return $this->onSuccess($succeed->makeVisible('cart_id'), 'Item Added to Cart');
    }

    public function updateCart(Request $request) {
        $validated = $request->validate(['data.qty'=>'required|integer|max:100','data.id'=>'required']);

        if($request->action !== "updateQuantity"){
            return $this->fail(400,"Invalid Action");
        }
        
        $id = $validated['data']['id'];
        $qty = $validated['data']['qty'];

        $cartEntity = CartEntity::with('entity')->findOrFail($id);
        
        if($qty === 0){
            
            $this->deleteCartItem($cartEntity);

            return $this->succeed(200,"Entity Item qty 0, Delete Item");
        }

        $cartEntity->update(['qty'=>$qty]);
        $cartEntity->refresh();

        return $this->onSuccess($cartEntity,"Cart Item Updated");
    }

    public function deleteCartItem(CartEntity $cartEntity) {
        return $cartEntity->delete();
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
