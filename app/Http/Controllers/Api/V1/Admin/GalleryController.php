<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Resources\V1\GalleryCollection;
use App\Http\Resources\V1\GalleryResource;
use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product): GalleryCollection|\Illuminate\Http\Response
    {

        return new GalleryCollection($product->gallery);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGalleryRequest  $request
     * @return GalleryResource
     */
    public function store(StoreGalleryRequest $request, Product $product): GalleryResource
    {
        $image = $request->file('image')->store('/public/images/products/galleries');
        $gallery = Gallery::query()->create([
            'title' => $request->get('title'),
            'image' => $image,
            'product_id' => $product->id,
        ]);

        return new GalleryResource($gallery);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Gallery $gallery)
    {
        //delete image from storage
        Storage::delete($gallery->image);

        //delete image from database
        $gallery->delete();
        return Response()->json([
            'massage' => 'image deleted successfully'
        ],200);
    }
}
