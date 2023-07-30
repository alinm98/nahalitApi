<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVisitRequest;
use App\Models\Visit;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $visits = Visit::query()->orderByDesc('count')->get();

        return Response()->json([
            'visits' => $visits
        ],200);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVisitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitRequest $request)
    {
        $url = substr($request->route()->uri, 7);

        $visit = Visit::query()->firstOrCreate([
            'url' => $url
        ]);
        $visit->count++;
        $visit->save();
    }


    public function allVisits()
    {
        $visit = new Visit();
        return $visit->subCounts();
    }


}
