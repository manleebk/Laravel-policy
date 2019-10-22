<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['product_name'];

    public static function getListProduct()
    {
        return DB::table('products')->select('id', 'product_name')->get();
    }

    public static function addProduct($prd)
    {
        $product = new Product();
        $product->product_name = $prd->product_name;
        $result = $product->save();
        if ($result) {
            return true;
        }
        return false;
    }
    public static function updateProduct(Product $prd)
    {
        $product = Product::find($prd->id);
        $product->product_name = $prd->product_name;
        $result = $product->save();
        if ($result) {
            return true;
        }
        return false;
    }
}
