<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\V1\NewsCollection;
use App\Http\Resources\V1\NewsResource;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return NewsCollection
     */
    public function index(): NewsCollection
    {
        return new NewsCollection(News::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNewsRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreNewsRequest $request): \Illuminate\Http\JsonResponse
    {
        $image = $request->file('image')->store('public/images/products');
        $image = str_replace('public', '/storage', $image);

        $news = News::query()->create([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'is_active' => $request->get('is_active'),
            'image' => url($image),
        ]);

        return response()->json($news,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return NewsResource
     */
    public function show(News $news): NewsResource
    {
        return new NewsResource($news);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNewsRequest  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateNewsRequest $request, News $news): \Illuminate\Http\JsonResponse
    {
        $image = $news->image;
        if ($request->file('image')) {
            Storage::delete($image);
            $image = $request->file('image')->store('public/images/products');
            $image = str_replace('public', '/storage', $image);
            $image = url($image);
        }

        $news->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'is_active' => $request->get('is_active'),
            'image' => $image,
        ]);

        return response()->json([
            'massage' => 'بروزرسانی با موفقیت انجام شد'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(News $news): \Illuminate\Http\JsonResponse
    {
        $news->delete();

        return response()->json([
            'massage' => 'خبر مورد نظر با موفقیت حذف شد'
        ],200);
    }
}
