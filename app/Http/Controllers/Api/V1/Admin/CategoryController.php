<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use http\Env\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return Response()->json([
            'categories' => new CategoryCollection(Category::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        $property_groups = $request->get('property_groups');

        $category = Category::query()->create([
            'title' => $request->get('title'),
            'category_id' => $request->get('category_id')
        ]);

        $category->propertyGroup()->attach($property_groups);

        return Response()->json([
            'status' => true,
            'category' => new CategoryResource($category),
            'property_groups' => $property_groups
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'category' => new CategoryResource($category)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): \Illuminate\Http\JsonResponse
    {

        //check for unique title
        $catExist = Category::query()->where('title', $request->get('title'))
            ->where('id', '!=', $category->id)->exists();

        if ($catExist) {
            return Response()->json([
                'error' => 'این عنوان اکنون وچود دارد'
            ], 400);
        }

        //update category in database
        $update = $category->update([
            'title' => $request->get('title'),
            'category_id' => $request->get('category_id'),
        ]);

        //sync property groups in database
        $category->propertyGroup()->sync($request->get('property_groups'));

        //return errors
        if (!$update) {
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
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category): \Illuminate\Http\JsonResponse
    {
        //delete property groups from database
        $category->propertyGroup()->detach();

        //delete category from database
        $delete = $category->delete();

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
