<?php

namespace App\Http\Controllers;


use App\Http\Requests\Subcategory\StoreRequest;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(Request $request, Category $category)
    {
        return $category->subcategories;
    }
    public function show(Request $request, Subcategory $subcategory)
    {
        return $subcategory;
    }
    public function getProducts(Request $request, Subcategory $subcategory)
    {
        return $subcategory->products;
    }
    public function store(StoreRequest $request, $category)
    {
        $data = $request->validated();
        $data['category_id'] = $category;
        Subcategory::create($data);

        return response([], 200);
    }
    public function destroy(Request $request, Subcategory $subcategory)
    {
        $subcategory->delete();
        return response([],204);
    }
}
