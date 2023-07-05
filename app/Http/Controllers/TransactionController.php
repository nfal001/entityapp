<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ApiHelpers;
    /**
     * admin get pendingTransaction
     */
    public function adminGetPendingTransactions() {
        
    }

    /**
     * Display List transaction per user
     */
    public function userIndex() {        
        
        return;
    }

    /**
     * From Update
     */
    public function commit() {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
