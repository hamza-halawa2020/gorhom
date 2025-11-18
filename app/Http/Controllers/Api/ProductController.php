<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\ApiResponse;
use App\Traits\FileUploadTrait;
use App\Traits\HasSlug;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'destroy');
        $this->middleware('limitReq');

    }

    use ApiResponse;
    use FileUploadTrait;
    use HasSlug;

    public function index()
    {
        $products = Product::with(['files', 'views','category'])->get();

        return $this->success(ProductResource::collection($products));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $this->generateSlug(Product::class, $data['title']);
        $data['created_by'] = Auth::id();

        if ($request->has('title')) {
            $data['title'] = $request->input('title');
        }

        if ($request->has('description')) {
            $data['description'] = $request->input('description');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'products');
        }

        $product = Product::create($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $this->uploadFile($file, 'products/files');
                $product->files()->create(['path' => $path]);
            }
        }

        return $this->success(new ProductResource($product->load('files')), 'Product created', 201);
    }

    public function show(Product $product)
    {
        $product->recordView();
        $product->load(['files',  'views','reviews','category']);

        return $this->success(new ProductResource($product));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

        $data = $request->validated();
        $data['slug'] = $this->generateSlug(Product::class, $data['title'], $product->id);

        if ($request->has('title')) {
            $data['title'] = $request->input('title');
        }

        if ($request->has('description')) {
            $data['description'] = $request->input('description');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'products');
        }

        $product->update($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $this->uploadFile($file, 'products/files');
                $product->files()->create(['path' => $path]);
            }
        }

        return $this->success(new ProductResource($product->load('files')), 'Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->success(null, 'Product deleted', 204);
    }
}
