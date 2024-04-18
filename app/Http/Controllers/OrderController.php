<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(Request $request, Product $product)
    {
        $order = $this->orderService->getUserCart();

        if (!$order) {
            $newOrder = $this->orderService->createOrder($product);
            return response($newOrder, 201);
        }

        if (!$this->orderService->productExistsInOrder($order, $product)) {

            $this->orderService->addProductToOrder($order, $product);

            return response('Product added to the order',200);
        }
        return response([], 200);
    }

    public function handleOrder(Request $request)
    {
        $order = $this->orderService->getUserCart();

        if($order->checkAvalability()){
            $this->orderService->updateOrder($request, $order);

            return response('Order handled.', 200);
        }

        return response([], 422);
    }

    public function cart(Request $request)
    {
        $order = $this->orderService->getUserCart();

        if ($order) {
            return response()->json($order->products, 200);
        }

        return response([], 204);
    }
    public function hadnledOrders(Request $request)
    {
        $orders = auth()->user()->orders()
            ->where('status', '!=', 0)
            ->orderBy('date', 'desc')
            ->get();

        if (!$orders->isEmpty()) {
            return response()->json($orders, 200);
        }

        return response([], 204);
    }
    public function removeProduct(Request $request, $productId)
    {
        $order = $this->orderService->getUserCart();

        $products = $this->orderService->getRawProducts($order);

        if (!isset($products[$productId])) {
            return response(['error' => 'Product not found in the cart'], 404);
        }
        unset($products[$productId]);

        $order->update(['products' => $products]);

        return response([], 204);
    }
    public function changeCount(Request $request, Product $product)
    {
        $order = $this->orderService->getUserCart();

        $products = $this->orderService->getRawProducts($order);
        $products[$product->id] = $request->newUserCount;

        $order->update(['products' => $products]);

        return response([], 204);
    }
    public function changeStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);
        return response([], 204);
    }

    public function soldProducts(Request $request)
    {
        return Order::where('status', '!=', 0)->orderBy('date', 'desc')->get();
    }
}
