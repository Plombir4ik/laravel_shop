<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function filter(Request $request, Category $category, Subcategory $subcategory)
    {
        $data = $request->all();

        $query = $subcategory->products();

        foreach ($data as $spec_id => $value) {
            $query->whereHas('bonds', function ($q)use($spec_id, $value){
                $q->where('spec_id', $spec_id)->whereIn('value', explode(',', $value));
            });
        }

        return $query->get();
    }

    public function show(Request $request, Product $product)
    {
        return $product;
    }

    public function index(Request $request)
    {
        return Product::all();
    }

    public function list(Request $request)
    {
        return Subcategory::all();
    }

    public function search(Request $request, $words)
    {
        $products = Product::where('name', 'like', "%{$words}%")
            ->orWhere('brand', 'like', "%{$words}%")
            ->orWhere('description', 'like', "%{$words}%")->get();

        return $products;
    }
    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        return response([],204);
    }

    public function store(StoreRequest $request, $subcategory)
    {
        $data = $request->validated();

        $product = $this->productService->createProduct($data, $subcategory);

        return response($product,200);
    }

    public function update(StoreRequest $request, Product $product)
    {
        $data = $request->validated();

        $product = $this->productService->updateProduct($product, $data);

        return response($product,204);
    }
}
