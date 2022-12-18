<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Resources\V1\Discountcollection;
use App\Http\Resources\V1\DiscountResource;
use App\Models\Discount;
use App\Models\Product;

class DiscountController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDiscountRequest $request
     * @return DiscountResource
     */
    public function store(StoreDiscountRequest $request, Product $product): DiscountResource
    {
        //store product in database
        $store = Discount::query()->create([
            'product_id' => $product->id,
            'value' => $request->get('value'),
        ]);
        //return discount
        return new DiscountResource($store);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Discount $discount
     * @return DiscountResource
     */
    public function show(Product $product, Discount $discount): DiscountResource
    {
        return new DiscountResource($discount);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDiscountRequest $request
     * @param \App\Models\Discount $discount
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDiscountRequest $request, Product $product, Discount $discount): \Illuminate\Http\JsonResponse
    {
        //update discount in database
        $update = $discount->update([
            'value' => $request->get('value')
        ]);

        //return errors
        if (!$update) {
            return response()->json([
                $update->errors()
            ], 400);
        }

        return response()->json([
            'massage' => 'discount updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Discount $discount
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product, Discount $discount): \Illuminate\Http\JsonResponse
    {
        //delete discount from database
        $delete = $discount->delete();

        //return errors
        if (!$delete) {
            return response()->json([
                $delete->errors()
            ], 400);
        }

        return Response()->json([
            'massage' => 'discount deleted successfully'
        ], 200);
    }
}
