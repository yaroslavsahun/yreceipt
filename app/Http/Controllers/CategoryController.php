<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()->get();

        return response()->json(CategoryResource::collection($categories));
    }

    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $category = new Category();
        $category->name = $request->validated('name');

        $path = $request->file('logo')->storePublicly('categories');
        $category->logo = $path;
        $category->save();

        return response()->json(new CategoryResource($category));
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(
            new CategoryResource(Category::query()->findOrFail($id))
        );
    }

    public function update(UpdateCategoryRequest $request, string $id): JsonResponse
    {
        $category = Category::query()->findOrFail($id);
        $category->name = $request->input('name');

        if($request->hasFile('logo')) {
            $path = $request->file('logo')->storePublicly('categories');
            $category->logo = $path;
        }

        $category->save();

        return response()->json(new CategoryResource($category));
    }

    public function destroy(string $id): JsonResponse
    {
        $category = Category::query()->findOrFail($id);

        Storage::delete($category->logo);

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
