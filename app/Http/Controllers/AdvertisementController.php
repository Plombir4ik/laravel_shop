<?php

namespace App\Http\Controllers;

use App\Http\Requests\Advertisement\StoreRequest;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $advers = Advertisement::all();

        return response()->json($advers, 200);
    }
    public function destroy(Request $request, Advertisement $ad)
    {
        $ad->delete();

        return response()->json([], 204);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Advertisement::create($request->all());

        return response()->json([], 204);
    }

    public function show(Request $request, Advertisement $ad)
    {
        return response()->json($ad, 200);
    }
    public function update(StoreRequest $request, Advertisement $ad)
    {
        $data = $request->validated();

        $ad->update($request->all());
        return response()->json($ad, 200);
    }
}
