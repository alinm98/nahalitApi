<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicesGroupRequest;
use App\Http\Requests\UpdateServicesGroupRequest;
use App\Http\Resources\V1\ServicesGroupCollection;
use App\Http\Resources\V1\ServicesGroupResource;
use App\Models\Category;
use App\Models\ServicesGroup;

class ServicesGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'services_group' => new ServicesGroupCollection(ServicesGroup::all())
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreServicesGroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreServicesGroupRequest $request): \Illuminate\Http\JsonResponse
    {
        //storing in database
        $store = ServicesGroup::query()->create([
            'title' => $request->get('title'),
            'services_group_id' => $request->get('services_group_id'),
            'first_value' => $request->get('first_value'),
            'second_value' => $request->get('second_value'),
            'description' => $request->get('description'),
        ]);

        //return result
        return response()->json([
            'status' => true,
            'services_group' => new ServicesGroupResource($store)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ServicesGroup $servicesGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ServicesGroup $servicesGroup): \Illuminate\Http\JsonResponse
    {

        return response()->json([
            'services_group' => new ServicesGroupResource($servicesGroup),
            'services_group_children' => new ServicesGroupCollection($servicesGroup->children)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateServicesGroupRequest $request
     * @param \App\Models\ServicesGroup $servicesGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateServicesGroupRequest $request, ServicesGroup $servicesGroup): \Illuminate\Http\JsonResponse
    {
        $servicesExist = Category::query()->where('title', $request->get('title'))
            ->where('id', '!=', $servicesGroup->id)->exists();

        if ($servicesExist) {
            return Response()->json([
                'error' => 'این عنوان اکنون وچود دارد'
            ], 400);
        }

        $update = $servicesGroup->update([
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
     * @param \App\Models\ServicesGroup $servicesGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ServicesGroup $servicesGroup)
    {
        $delete = $servicesGroup->delete();

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
