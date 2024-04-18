<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['user_id'];
    protected $appends = ['total', 'user'];

    public function getProductsAttribute($value)
    {
        $products = json_decode($value, true);
        $tempArr = [];

        foreach ($products as $productId => $order_quantity) {
            $product = Product::find($productId);
            if ($product) {
                $product->user_count = $order_quantity;
                $tempArr[] = $product;
            }
        }

        return $tempArr;
    }

    public function getTotalAttribute(){
        $price = 0;
        foreach ($this->products as $item) {
            $price += $item->user_count * $item->price;
        }
        return $price;
    }

    public function getDateAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getUserAttribute(){
        $user = User::find($this->user_id);
        return $user->email;
    }

    public function checkAvalability()
    {
        $products = json_decode($this->getRawOriginal('products'), true);

        foreach ($products as $product_id => $order_quantity) {
            $product = Product::find($product_id);
            if($product){
                if ($order_quantity > $product->count) {
                    return false;
                }
                $product->count -= $order_quantity;
                $product->save();
            } else {
                return false;
            }
        }
        return true;
    }
}
