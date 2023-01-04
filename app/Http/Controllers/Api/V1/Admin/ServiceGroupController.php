<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceGroupRequest;
use App\Http\Requests\UpdateServiceGroupRequest;
use App\Http\Resources\V1\ServiceGroupCollection;
use App\Http\Resources\V1\ServiceGroupResource;
use App\Models\Category;
use App\Models\ServiceGroup;


class ServiceGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'service_groups' => new ServiceGroupCollection(ServiceGroup::all())
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceGroupRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreServiceGroupRequest $request): \Illuminate\Http\JsonResponse
    {

        //storing in database
        $store = ServiceGroup::query()->create([
            'title' => $request->get('title'),
            'service_group_id' => $request->get('services_group_id'),
            'first_value' => $request->get('first_value'),
            'second_value' => $request->get('second_value'),
            'description' => $request->get('description'),
        ]);

        $store->service()->attach($request->get('services'));
        //return result
        return response()->json([
            'status' => true,
            'service_groups' => new ServiceGroupResource($store)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceGroup  $serviceGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ServiceGroup $serviceGroup): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'service_groups' => new ServiceGroupResource($serviceGroup),
            'service_groups_children' => new ServiceGroupCollection($serviceGroup->children)
        ], 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceGroupRequest  $request
     * @param  \App\Models\ServiceGroup  $serviceGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateServiceGroupRequest $request, ServiceGroup $serviceGroup): \Illuminate\Http\JsonResponse
    {
        $serviceExist = ServiceGroup::query()->where('title', $request->get('title'))
            ->where('id', '!=', $serviceGroup->id)
            ->exists();

        if ($serviceExist) {
            return Response()->json([
                'error' => 'این عنوان اکنون وچود دارد'
            ], 400);
        }

        $update = $serviceGroup->update([
            'title' => $request->get('title'),
            'services_group_id' => $request->get('services_group_id'),
            'first_value' => $request->get('first_value'),
            'second_value' => $request->get('second_value'),
            'description' => $request->get('description'),
        ]);

        //return errors
        if (!$update){
            return response()->json([
                'status' => false,
                'massage' => 'خطایی در عملیات بروزرسانی رخ داده است'
            ], 400);
        }

        return Response()->json([
            'status' => true,
            'massage' => 'بروزرسانی با موفقیت انجام شد'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceGroup  $serviceGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ServiceGroup $serviceGroup): \Illuminate\Http\JsonResponse
    {
        $delete = $serviceGroup->delete();

        if (!$delete) {
            return response()->json([
                'status' => false,
                'massage' => 'خطایی در عملیات حذف رخ داده است'
            ], 400);
        }


        return Response()->json([
            'status' => true,
            'massage' => 'حذف با موفقیت انجام شد'
        ], 200);
    }
}
