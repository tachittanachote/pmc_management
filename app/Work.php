<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    //
    protected $fillable = [
        'user_id', 'name', 'product_code', 'product_id','tailor_id','quantity','image_url','detail',
    ];

    public static function getWorkByUserId($userId) {
        return Work::where('user_id', $userId)->get();
    }

    public static function getWorkByTailorId($tailorId) {
        return Work::where('tailor_id', $tailorId)->get();
    }

    public static function countUserWorkbyUserId($userId) {
        return Work::where('user_id', $userId)->sum('quantity');
    }

    public static function countTailorWorkbyTailorId($tailorId) {
        return Work::where('tailor_id', $tailorId)->sum('quantity');
    }


    public static function getSalaryByUserId($userId, $startDate, $endDate) {
        $works = Work::where('user_id', $userId)->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])->get();
        return $works;
    }

    public static function getSalaryByTailorId($tailorId, $startDate, $endDate) {
        $works = Work::where('tailor_id', $tailorId)->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])->get();
        return $works;
    }

    public static function getAllWorkByUserIdAndProductId($userId, $productId) {
        $works = Work::where('user_id', $userId)->where('product_id', $productId)->get();
        return $works;
    }

    public static function getAllWorkByTailorIdAndProductId($tailorId, $productId) {
        $works = Work::where('tailor_id', $tailorId)->where('product_id', $productId)->get();
        return $works;
    }


}
