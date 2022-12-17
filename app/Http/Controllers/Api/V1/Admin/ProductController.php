<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Models\Category;
use App\Models\Product;
use http\Env\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProductCollection
     */
    public function index(): ProductCollection
    {
        return new ProductCollection(Product::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return ProductResource
     */
    public function store(\App\Http\Requests\StoreProductRequest $request): ProductResource
    {
        //store image in public
        $image = $request->file('image')->store('public/images/products');

        //store product in database
        $product = Product::query()->create([
            'title' => $request->get('title'),
            'price' => $request->get('price'),
            'image' => $image,
            'description' => $request->get('description'),
            'category_id' => $request->get('category_id'),
        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product): \Illuminate\Http\JsonResponse
    {
        //store new image(if exist)
        $image = $product->image;
        if ($request->file('image') != null) {
            Storage::delete($image);
            $image = $request->file('image')->store('public/images/products');
        }

        //check for unique title
        $productExist = Category::query()->where('title' , $request->get('title'))
            ->where('id' , '!=' , $product->id)->exists();

        if ($productExist){
            return Response()->json([
                'error' => 'this title already exist'
            ],400);
        }

        //update product
        $update = $product->update([
            'title' => $request->get('title'),
            'price' => $request->get('price'),
            'image' => $image,
            'description' => $request->get('description'),
            'category_id' => $request->get('category_id'),
        ]);
        if (!$update){
            return response()->json([
                $update->errors()
            ],400);
        }

        return response()->json([
            'massage' => 'products updated successfully'
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product): \Illuminate\Http\JsonResponse
    {
        //delete image from storage
        $image = $product->image;
        Storage::delete($image);

        //delete product from database
        $product->delete();
        return Response()->json([
            'massage' => 'product deleted successfully'
        ],200);
    }
}
