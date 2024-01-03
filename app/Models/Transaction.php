<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['account_head_id', 'date', 'description', 'amount', 'type'];

    public function journalEntries(){
        return $this->hasMany(JournalEntry::class, 'transaction_id');
    }
}
