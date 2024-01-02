<?php

namespace Database\Seeders;

use App\Models\AccountHead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accountHeads = ['Cash', 'Bank', 'Capital', 'Purchase', 'Sale', 'Account Payable', 'Account Receivable', 'Expense', 'Purchase Return', 'Sales Return'];

        foreach ($accountHeads as $accountHead) {
            AccountHead::create([
                'name' => $accountHead
            ]);
        }
    }
}
