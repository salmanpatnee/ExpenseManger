<?php
namespace App\Services;

use App\Models\JournalEntry;

class JournalEntryService
{
    public function recordEntry($transactionId, $accountHeadId, $entryType, $amount)
    {
        JournalEntry::create([
            'transaction_id' => $transactionId,
            'account_head_id' => $accountHeadId,
            'entry_type' => $entryType,
            'amount' => $amount,
        ]);
    }
}
