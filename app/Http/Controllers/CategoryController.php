<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return Category::all();
    }

    public function show(Request $request, Category $category)
    {
        return $category->subcategories;

    }
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Category::create($data);

        return response([], 200);
    }
    public function destroy(Request $request, Category $category)
    {
        $category->delete();
        return response([], 200);
    }
}
