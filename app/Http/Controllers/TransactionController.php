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
        $transactions = Transaction::with(
            'address.district',
            'address.province',
            'address.city'
        )->where('order_status','Pending')->get();

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

        return $this->onSuccess($transaction,"Successfully Fetch Transaction ID: $transaction->id");
    }

    /**
     *  Commit New Transaction
     */
    public function commit(Request $request)
    {
        // get user from request authorization 
        $user = $request->user();

        if ($user->activeCart->itemList()->count() <= 0){
            return $this->fail(422,"Empty Cart Item, Please Add One");
        }
        
        $total_price = collect($user->activeCart->itemList)->sum(function ($item) {
            return $item->last_price * $item->quantity;
        });
        
        try {
            DB::beginTransaction();

            $choosenAddress = $user->choosenAddress;

            if (!$choosenAddress) throw new Exception("Please Choose At least one address");

            $choosenAddressId = $choosenAddress->id;
            $activeCart = $user->activeCart;

            $transactionCart = $user->transactions()->create([
                'cart_id' => $activeCart->id,
                'address_id' => $choosenAddressId,
                'total_price' => $total_price
            ]);

            // $transactionCart = $activeCart->hasOne(Transaction::class)->create(
            //     [
            //         "user_id" => $user->id,
            //         "address_id" => $choosenAddressId,
            //         "total_price" => $total_price
            //     ]
            // );
            
            $activeCart->update(['status' => 'saved']);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $msg = $e->getMessage();
            $errCode = $e->getCode();
            
            // return $e;
            return $this->fail(400, "Transaction Fail - $errCode","$msg");
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
