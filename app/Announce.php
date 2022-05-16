<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announce extends Model
{
    //
    protected $fillable = [
        'message', 'image_url', 'status'
    ];

    public static function getAnnounce() {
        return Announce::get();
    }
}
