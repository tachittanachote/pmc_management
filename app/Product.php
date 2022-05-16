<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'product_name', 'price_tailor', 'price_seamstress', 'is_fix'
    ];

    public static function getProductNameByProductId($productId) {
        $product = Product::where('id', $productId)->first();
        return $product->product_name;
    }

    public static function getTailorPriceByProductId($productId) {
        $product = Product::where('id', $productId)->first();
        return $product->price_tailor;
    }

    public static function getSeamstressPriceByProductId($productId) {
        $product = Product::where('id', $productId)->first();
        return $product->price_seamstress;
    }

    public static function isFixProduct($productId) {
        $product = Product::where('id', $productId)->first();
        return $product->is_fix;
    }

}
