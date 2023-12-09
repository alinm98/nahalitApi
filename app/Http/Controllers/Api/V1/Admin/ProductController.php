<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\V1\Discountcollection;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use http\Env\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        //$this->middleware(checkPermissions::class.":view-product")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-product")->only(['store']);
        $this->middleware(checkPermissions::class.":update-product")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-product")->only(['delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return Response()->json([
            'products' => new ProductCollection(Product::all()),
            'discounts' => new Discountcollection(Discount::all())
        ]);
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
        $image = str_replace('public', '/storage', $image);

        $file = $request->file('file')->store('public/upload/products');
        $file = str_replace('public', '/storage', $file);


        //store product in database
        $product = Product::query()->create([
            'title' => $request->get('title'),
            'price' => $request->get('price'),
            'image' => url($image),
            'file' => url($file),
            'description' => $request->get('description'),
            'category_id' => $request->get('category_id'),
        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        return Response()->json([
            'product' => new ProductResource($product),
            'discount' => $product->discount,
            'comments' => $product->comments,
        ]);
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
            $image = str_replace('public', '/storage', $image);
        }

        //store new file(if exist)
        $file = $product->file;
        if ($request->file('file') != null) {
            Storage::delete($file);
            $file = $request->file('image')->store('public/upload/products');
            $file = str_replace('public', '/storage', $file);
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
            'image' => url($image),
            'file' => url($file),
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

    public function search($value): \Illuminate\Http\JsonResponse
    {
        $products = Product::query()->where('title' ,'like' , '%'.$value.'%')->get();

        return Response()->json([
            'products' => new ProductCollection($products)
        ]);
    }
}
