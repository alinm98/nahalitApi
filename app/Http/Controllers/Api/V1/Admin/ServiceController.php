<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\V1\ServiceCollection;
use App\Http\Resources\V1\ServiceResource;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'services' => new ServiceCollection(Service::all())
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreServiceRequest $request): \Illuminate\Http\JsonResponse
    {
        $store = Service::query()->create([
            'title' => $request->get('title')
        ]);

        return response()->json([
            'status' => true,
            'service' => new ServiceResource($store)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Service $service): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'service' => new ServiceResource($service)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $update = $service->update([
            'title' => $request->get('title')
        ]);

        //return errors
        if (!$update) {
            return response()->json([
                'status' => false,
                'massage' => '?????????? ???? ???????????? ?????????????????? ???? ???????? ??????'
            ], 400);
        }

        return Response()->json([
            'status' => true,
            'massage' => '?????????????????? ???? ???????????? ?????????? ????'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Service $service)
    {
        $delete = $service->delete();

        if (!$delete) {
            return response()->json([
                'status' => false,
                'massage' => '?????????? ???? ???????????? ?????? ???? ???????? ??????'
            ], 400);
        }


        return Response()->json([
            'status' => true,
            'massage' => '?????? ???? ???????????? ?????????? ????'
        ], 200);
    }
}
