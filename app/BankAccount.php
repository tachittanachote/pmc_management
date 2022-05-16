<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    //
    protected $fillable = [
        'user_id', 'bank_name', 'bank_no', 'account_name',
    ];

    public static function getBankAccountDetailByUserId($userId) {
        return BankAccount::where("user_id", $userId)->first();
    }
}
