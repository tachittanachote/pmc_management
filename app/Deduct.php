<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deduct extends Model
{
    //
    protected $fillable = [
        'user_id', 'detail', 'amount', 'date'
    ];

    public static function getDeductByUserId($userId) {
        return Deduct::where('user_id', $userId)->get();
    }

}
