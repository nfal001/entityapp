<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use ApiHelpers;
    /**
     * admin get pendingTransaction
     */
    public function adminGetPendingTransactions()
    {
        
    }
    
    public function adminGetProcessingTransactions()
    {
        $transactions = Transaction::with('address.district','address.province','address.city')->where('order_status','Pending')->get();
        return $this->onSuccess($transactions,"Successfully Fetch Transactions");
    }

    /**
     * Display List transaction per user
     */
    public function userIndex()
    {
        $transactions = auth()->user()->transactions->load('address');
        return $this->onSuccess($transactions,"Successfuly Fetch Transactions");
    }
    public function userIndexOptional()
    {
        $transactions = auth()->user()->transactions->load('address.district','address.province','address.city','cart.itemList.entity');
        return $this->onSuccess($transactions,"Successfuly Fetch Transactions");
    }

    public function userShow(Transaction $transaction) {

        $transaction->load('address.district','address.province','address.city','cart.itemList.entity:id,name,price');
        // $transaction->total_price = rand(12331,132878);
        
        return $this->onSuccess($transaction,"Successfully Fetch Transaction ID: $transaction->id");
    }
    /**
     * From Update
     */
    public function commit(Request $request)
    {

        // some bug found
        $user = $request->user();

        
        if ($user->activeCart->itemList()->count() <= 0){
            return $this->fail(422,"Empty Cart Item, Please Add One");
        }
        
        $total_price = collect($user->activeCart->itemList()->get())->sum(function ($item) {
            return $item->last_price * $item->qty;
        });

        DB::beginTransaction();

        try {

            $choosenAddress = $user->choosenAddress()->get();
            $choosenAddressId = collect($choosenAddress)->value('id');
            $activeCart = $user->activeCart;
            
            /**
             * in next update please change it to 
             * $user->hasOneOrMany(Transaction::class)->create(['something']);
             * so, it will be make sense
             */
            $transactionCart = $activeCart->hasOne(Transaction::class)->create(
                [
                    "user_id" => $user->id,
                    "address_id" => $choosenAddressId,
                    "payment_proof" => "https://loremflickr.com/512/512/meatball", //dummy data, should nullable in next fresh migration
                    "order_status" => "Pending", //dummy data, doesn't need to fill order_status when checkout action happened
                    "total_price" => $total_price
                ]
            );
            
            $activeCart->update(['status' => 'saved']);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->fail(400, "Transaction Fail");
        }

        $activeCart->refresh();

        return $this->onSuccess(['choosen_cart'=>$activeCart,'transaction'=>$transactionCart], 'Transaction Created');
    }

    public function updateTransaction() {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('address.district','address.province','address.city')->get();
        return $this->onSuccess($transactions,"Successfully Fetch Transactions");
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
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'action'=>'required|in:pending,delivering,delivered,paid',
        ]);

        $action = collect([
            'pending'=>['order_status'=>'Pending','order_status_message'=>'Preparing Order'],
            'delivering'=>['order_status'=>'Delivering','order_status_message'=>'Delivering Your Order'],
            'delivered'=>['order_status'=>'Delivered','order_status_message'=>'Order Delivered'],
            'paid'=>['payment_status'=>'Delivering','order_status'=>'Delivering','order_status_message'=>'Delivering Your Order']
        ])->value($validated['action']);

        $transaction->update($action);

        return $this->onSuccess($transaction,"Transaction Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
