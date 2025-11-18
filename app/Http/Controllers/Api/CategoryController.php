<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'destroy');
        $this->middleware('limitReq');

    }

    use ApiResponse;

    public function index()
    {
        $categories = Category::with('children')->get();

        return $this->success(CategoryResource::collection($categories));
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        if ($request->has('name')) {
            $data['name'] = $request->input('name');
        }

        $category = Category::create($data);

        return $this->success(new CategoryResource($category), 'Category created', 201);
    }

    public function show(Category $category)
    {
        $category->load('children');

        return $this->success(new CategoryResource($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if ($request->has('name')) {
            $data['name'] = $request->input('name');
        }

        $category->update($data);

        return $this->success(new CategoryResource($category), 'Category updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return $this->success(null, 'Category deleted', 204);
    }
}
