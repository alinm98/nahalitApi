<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'banners' => Banner::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBannerRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBannerRequest $request): \Illuminate\Http\JsonResponse
    {
        $image = $request->file('image')->store('public/images/products');
        $image = str_replace('public', '/storage', $image);

        $banner = Banner::query()->create([
            'title' => $request->get('title'),
            'image' => url($image)
        ]);

        return response()->json($banner,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Banner $banner): \Illuminate\Http\JsonResponse
    {
        return response()->json($banner,200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBannerRequest  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBannerRequest $request, Banner $banner): \Illuminate\Http\JsonResponse
    {
        $image = $banner->image;
        //dd($request->file('image'));
        if (!empty($request->file('image'))) {
            $banner->deleteImage();
            $image = $request->file('image')->store('public/images/products');
            $image = str_replace('public', '/storage', $image);
        }

        $banner->update([
            'title' => $request->get('title'),
            'image' => url($image)
        ]);

        return response()->json([
            'massage' => 'بروزرسانی با موفقیت انجام شد'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Banner $banner): \Illuminate\Http\JsonResponse
    {
        $banner->deleteImage();
        $banner->delete();
        return response()->json([
            'massage' => 'بنر با موفقیت حذف شد'
        ],200);
    }
}
