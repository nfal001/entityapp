<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Models\CartEntity;
use App\Models\Entity;
use App\Models\Features\Cart;
use App\Models\User;
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
            $created = $this->createNewActiveCart($user)->load('itemList.entity');
            $itemList = $created;
        } else {
            $freshActiveCart = $oldActiveCart->first();
            $itemList = $freshActiveCart;
        }


        return $this->onSuccess(['cart' => $itemList], "Successfully Fetch Cart Detail");
    }

    protected function createNewActiveCart(User $user)
    {
        $newCart = new Cart(['status','active']);
        return $user->activeCart()->save($newCart);
    }

    protected function checkEntityExistInSelectedCart(Entity $entity, Cart $cart) {
        $cartEntity = CartEntity::where('entity_id',$entity->id)->where('cart_id',$cart->id);

        return $cartEntity->count() >= 1;
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'data.id' => 'required|uuid|exists:entities,id',
            'data.name' => 'required',
        ]);

        $user = $request->user();
        
        /**
         * If Active Cart Not Exist
         */
        if(!$activeCart = $user->activeCart){
            $activeCart = $this->createNewActiveCart($request->user());
        };

        /**
         * Find Entity related to data.id
         */
        $id = $validated['data']['id'];
        $entity = Entity::find($id);

        if($this->checkEntityExistInSelectedCart($entity,$activeCart)){
            return $this->fail(422,"Entity Already Added");
        };
        
        // Insert Into CartEntity
        $succeed = $activeCart->addToCart($entity);
        
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
