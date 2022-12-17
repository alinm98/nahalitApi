<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoryCollection
     */
    public function index(): CategoryCollection
    {
        return new CategoryCollection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return CategoryResource
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = Category::query()->create([
            'title' => $request->get('title'),
            'category_id' => $request->get('category_id')
        ]);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
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
        $catExist = Category::query()->where('title' , $request->get('title'))
            ->where('id' , '!=' , $category->id)->exists();

        if ($catExist){
            return Response()->json([
                'error' => 'this title already exist'
            ],400);
        }

        //update category in database
        $update = $category->update([
            'title' => $request->get('title'),
            'category_id' => $request->get('category_id'),
        ]);

        //return errors
        if (!$update){
            return response()->json([
                $update->errors()
            ],400);
        }

        return Response()->json([
            'massage' => 'Category updated successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category): \Illuminate\Http\JsonResponse
    {
        //delete category from database
        $category->delete();
        return Response()->json([
            'massage' => 'category deleted successfully'
        ],200);
    }
}
