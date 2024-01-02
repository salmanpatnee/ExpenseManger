<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHead extends Model
{
    use HasFactory;

    const CASH_ID = 1;
    const BANK_ID = 2;
    const CAPITAL_ID = 3;
    const PURCHASE_ID = 4;
    const SALE_ID = 5;
    const ACCOUNT_PAYABLE_ID = 6;
    const ACCOUNT_RECEIVABLE_ID = 7;
    const EXPENSE_ID = 8;
    const PURCHASE_RETURN_ID = 9;
    const SALES_RETURN = 10;

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
