<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shop\CreateShopRequest;
use App\Http\Requests\Shop\UpdateShopRequest;
use App\Models\Shop;
use App\Resources\ShopResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index(): JsonResponse
    {
        $shops = Shop::query()->get();

        return response()->json(ShopResource::collection($shops));
    }

    public function store(CreateShopRequest $request): JsonResponse
    {
        $shop = new Shop();
        $shop->name = $request->validated('name');
        $shop->color = $request->validated('color');
        $path = $request->file('logo')->storePublicly('shops');
        $shop->logo = $path;
        $shop->save();

        return response()->json(new ShopResource($shop));
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(
            new ShopResource(Shop::query()->findOrFail($id))
        );
    }

    public function update(UpdateShopRequest $request, string $id): JsonResponse
    {
        $shop = Shop::query()->findOrFail($id);
        $shop->name = $request->validated('name');
        $shop->color = $request->validated('color');

        if($request->hasFile('logo')) {
            $path = $request->file('logo')->storePublicly('shops');
            $shop->logo = $path;
        }

        $shop->save();

        return response()->json(new ShopResource($shop));
    }

    public function destroy(string $id): JsonResponse
    {
        $shop = Shop::query()->findOrFail($id);

        Storage::delete($shop->logo);

        $shop->delete();

        return response()->json(['message' => 'Shop deleted']);
    }
}
