<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\Http\Resources\V1\SourceCollection;
use App\Http\Resources\V1\SourceResource;
use App\Models\Source;


class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return SourceCollection
     */
    public function index(): SourceCollection
    {
        return new SourceCollection(Source::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSourceRequest $request): \Illuminate\Http\JsonResponse
    {

        $value = bin2hex(random_bytes(16));
        $path = 'https://api.nahalit.ir/source/getAdSource/'.$value;

        $source = Source::query()->create([
            'title' => $request->get('title'),
            'value' => $value,
            'path' => $path,
            'count' => 0
        ]);

        return response()->json($source,201);
    }

    /**
     * increase the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getSource($value): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $source = Source::query()->where('value', $value)->first();
        if (!$source){
            return redirect('http://nahalit.ir/');
        }

        $source->update([
            'count' => $source->count + 1
        ]);

        return redirect('http://nahalit.ir/');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Source $source): \Illuminate\Http\JsonResponse
    {
        $source->delete();

        return response()->json([
            'massage' => 'حذف با موفقیت انجام شد'
        ],200);
    }
}
