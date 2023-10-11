<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Product;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return Response()->json([
            'tags' => Tag::all()
        ],200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTagRequest $request): \Illuminate\Http\JsonResponse
    {
        $tag = Tag::query()->create([
            'title' => $request->get('title'),
            'product_id' => $request->get('product_id')
        ]);

        return Response()->json($tag,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tag $tag): \Illuminate\Http\JsonResponse
    {
        return Response()->json($tag,200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTagRequest $request, Tag $tag): \Illuminate\Http\JsonResponse
    {
        $tag->update([
            'title' => $request->get('title'),
            'product_id' => $request->get('product_id')
        ]);

        return Response()->json([
            'massage' => 'به روزرسانی با موفقیت انجام شد'
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Tag $tag): \Illuminate\Http\JsonResponse
    {
        $tag->delete();

        return Response()->json([
            'massage' => 'حذف با موفقیت انجام شد'
        ],200);
    }

    public function tagProduct(Product $product): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'tags' => $product->tag,
        ],200);
    }
}
