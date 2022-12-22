<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Http\Resources\V1\PropertyCollection;
use App\Http\Resources\V1\PropertyResource;
use App\Models\Property;
use http\Env\Response;
use http\Url;
use Symfony\Component\Console\Helper\QuestionHelper;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PropertyCollection
     */
    public function index(): PropertyCollection
    {
        return new PropertyCollection(Property::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePropertyRequest $request
     * @return PropertyResource
     */
    public function store(StorePropertyRequest $request): PropertyResource
    {
        //store property in database
        $store = Property::query()->create([
            'title' => $request->get('title'),
            'property_group_id' => $request->get('property_group_id')
        ]);

        return new PropertyResource($store);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Property $property
     * @return PropertyResource
     */
    public function show(Property $property): PropertyResource
    {
        return new PropertyResource($property);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePropertyRequest $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePropertyRequest $request, Property $property): \Illuminate\Http\JsonResponse
    {
        //updating property in database
        $update = $property->update([
            'title' => $request->get('title'),
            'property_group_id' => $request->get('property_group_id')
        ]);

        //return error
        if (!$update){
            return response()->json([
                'status' => false,
                'massage' => 'خطایی در بروزرسانی رخ داده است'
            ],400);
        }

        //return success massage
        return response()->json([
            'status' => true,
            'massage' => 'بروزرسانی با موفقیت انجام شد'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Property $property)
    {
        //deleting property from database
        $delete = $property->delete();

        //check and return error
        if (!$delete){
            return response()->json([
                'status' => false,
                'massage' => 'خطایی در عملیات حذف رخ داده است'
            ],400);
        }

        //return success massage
        return response()->json([
            'status' => true,
            'massage' => 'عملیات حذف با موفقیت انجام شد'
        ],200);
    }
}
