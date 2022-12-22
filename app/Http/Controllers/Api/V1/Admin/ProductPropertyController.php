<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Product;
use http\Env\Request;

class ProductPropertyController extends Controller
{
    public function index(Product $product)
    {
        return response()->json([
            'property_group' => $product->category->propertyGroup,
            'product' => $product
        ],200);
    }

    public function store(Request $request, Product $product)
    {
        $properties = collect($request->get('properties'))->filter( function ($item){
            if (!empty($item['value'])){
                return $item;
            }
        });

        $product->properties()->sync($properties);

        return Response()->json([
            'status' => true,
            'massage' => 'ویژگی ها با موفقیت اضافه شدند'
        ], 200);


    }
}
