<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyGroupRequest;
use App\Http\Requests\UpdatePropertyGroupRequest;
use App\Http\Resources\V1\PropertyGroupeCollection;
use App\Http\Resources\V1\PropertyGroupeResource;
use App\Models\Category;
use App\Models\PropertyGroup;

class PropertyGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PropertyGroupeCollection
     */
    public function index(): PropertyGroupeCollection
    {
        return new PropertyGroupeCollection(PropertyGroup::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePropertyGroupRequest $request
     * @return PropertyGroupeResource
     */
    public function store(StorePropertyGroupRequest $request): PropertyGroupeResource
    {
        //store property group
        $store = PropertyGroup::query()->create([
            'title' => $request->get('title')
        ]);
        //return stored property group
        return new PropertyGroupeResource($store);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\PropertyGroup $propertyGroup
     * @return PropertyGroupeResource
     */
    public function show($id): PropertyGroupeResource
    {
        $propertyGroup = PropertyGroup::query()->where('id', $id)->firstOrFail();

        return new PropertyGroupeResource($propertyGroup);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePropertyGroupRequest $request
     * @param \App\Models\PropertyGroup $propertyGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePropertyGroupRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $propertyGroup = PropertyGroup::query()->where('id', $id)->firstOrFail();

        $propertyGroupExist = PropertyGroup::query()->where('title', $request->get('title'))
            ->where('id', '!=', $propertyGroup->id)->exists();

        if ($propertyGroupExist) {
            return Response()->json([
                'error' => 'this title already exist'
            ], 400);
        }


        //update property group
        $update = $propertyGroup->update([
            'title' => $request->get('title'),
        ]);


        //return errors
        if (!$update) {
            return response()->json([
                $update->errors()
            ], 400);
        }

        //return success massage
        return response()->json([
            'massage' => 'Property Group updated successfully'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\PropertyGroup $propertyGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function destroy($id): \Illuminate\Http\JsonResponse
    {
        $propertyGroup = PropertyGroup::query()->where('id', $id)->firstOrFail();
        //delete property group
        $delete = $propertyGroup->delete();

        //return errors
        if (!$delete) {
            return response()->json([
                $delete->errors()
            ], 400);
        }

        //return success massage
        return response()->json([
            'massage' => 'Property Group deleted successfully'
        ], 200);


    }
}
