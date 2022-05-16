<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'role', 'password', 'line_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function getRole()
    {
        switch($this->role) {
            case "admin": {
                return "ผู้ดูแลระบบ";
            }
            case "tailor": {
                return "ช่างตัด";
            }
            case "seamstress": {
                return "ช่างเย็บ";
            }
        }
    }

    public static function formatRole($role)
    {
        switch($role) {
            case "admin": {
                return "ผู้ดูแลระบบ";
            }
            case "tailor": {
                return "ช่างตัด";
            }
            case "seamstress": {
                return "ช่างเย็บ";
            }
        }
    }

    public static function getUserNameByUserId($userId) {
        $user = User::where('id', $userId)->first();
        return $user->name;
    }
}
