<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\AccountHead;
use App\Models\Expense;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Services\JournalEntryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    private $journalEntryService;

    public function __construct(JournalEntryService $journalEntryService)
    {
        $this->journalEntryService = $journalEntryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Transaction::where('type', 'expense')->with('journalEntries')->get();
        return ExpenseResource::collection($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        try {

            DB::beginTransaction();

            $attributes = $request->all();

            $attributes['account_head_id']  = AccountHead::EXPENSE_ID;
            $attributes['type']             = 'expense';

            $transaction = Transaction::create($attributes);

            // Expense: Debit
            $this->journalEntryService->recordEntry($transaction->id, $attributes['account_head_id'], 'debit', $attributes['amount']);

            // Cash: Credit
            $this->journalEntryService->recordEntry($transaction->id, AccountHead::CASH_ID, 'credit', $attributes['amount']);

            DB::commit();

            return 'Expense added.';
        } catch (\Exception $e) {
            DB::rollBack();
            return 'Failed to reverse expense entry: ' . $e->getMessage();
        }
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
    public function destroy(Transaction $expense)
    {
        try {

            DB::beginTransaction();

            $transaction = $expense;

            // Cash: Debit
            $this->journalEntryService->recordEntry($transaction->id, AccountHead::CASH_ID, 'debit', $transaction->amount);

            // Expense: Credit
            $this->journalEntryService->recordEntry($transaction->id, $transaction->account_head_id, 'credit', $transaction->amount);

            $transaction->delete();

            DB::commit();

            return 'Expense deleted.';

        } catch (\Exception $e) {
            DB::rollBack();
            return 'Failed to reverse expense entry: ' . $e->getMessage();
        }
    }
}
