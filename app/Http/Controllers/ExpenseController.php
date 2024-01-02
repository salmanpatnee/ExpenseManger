<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\AccountHead;
use App\Models\Expense;
use App\Models\JournalEntry;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        $attributes = $request->all();

        $attributes['account_head_id'] = AccountHead::EXPENSE_ID;

        $transaction = Transaction::create($attributes);

        JournalEntry::create([
            'transaction_id' => $transaction->id,
            'account_head_id' => $attributes['account_head_id'],
            'entry_type' => 'debit',
            'amount' => $attributes['amount']
        ]);

        JournalEntry::create([
            'transaction_id' => $transaction->id,
            'account_head_id' => AccountHead::CASH_ID,
            'entry_type' => 'credit',
            'amount' => $attributes['amount']
        ]);

        return 'Expense added.';
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
