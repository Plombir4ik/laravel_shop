<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder($product)
    {
        return Order::create([
            'user_id' => auth()->user()->getAuthIdentifier(),
            'products' => json_encode([$product->id => 1]),
            'status' => 0,
        ]);
    }

    public function updateOrder($request, $order)
    {
        $order->update([
            'status' => 1,
            'date' => Carbon::now(),
            'payment_method' => $request->payment_method,
            'delivery_method' => $request->delivery_method,
            'region' => $request->region,
            'city' => $request->city,
            'delivery_address' => $request->delivery_address,
        ]);
    }

    public function productExistsInOrder($order, $product)
    {
        $products = $this->getRawProducts($order);
        return isset($products[$product->id]);
    }

    public function addProductToOrder($order, $product)
    {
        $products = $this->getRawProducts($order);
        $products[$product->id] = 1;
        $order->update(['products' => $products]);
    }

    public static function getRawProducts($order)
    {
        return json_decode($order->getRawOriginal('products'), true);
    }

    public static function getUserCart()
    {
        return auth()->user()->orders()->where('status', 0)->first();
    }
}
