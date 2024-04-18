<?php

namespace App\Http\Controllers;

use App\Http\Requests\Spec\StoreRequest;
use App\Models\Spec;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SpecController extends Controller
{
    public function index(Request $request, Subcategory $subcategory)
    {
        $specs = $subcategory->specs;

        return response()->json($specs, 200);
    }
    public function show(Request $request, Spec $spec)
    {
        return response()->json($spec, 200);
    }
    public function store(StoreRequest $request,$subcategory)
    {
        $data = $request->validated();
        $data['subcategory_id'] = $subcategory;
        $spec = Spec::firstOrCreate(['name' => $data['name']], $data);

        return response()->json([$spec], 200);
    }
    public function destroy(Spec $spec)
    {
        $spec->delete();

        return response()->json([], 204);
    }
    public function update(StoreRequest $request,Spec $spec)
    {
        $data = $request->validated();
        $spec->update($data);

        return response()->json([], 200);
    }

}
