<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Resources\V1\Discountcollection;
use App\Http\Resources\V1\DiscountResource;
use App\Models\Discount;
use App\Models\Product;
use http\Env\Response;

class DiscountController extends Controller
{
    public function __construct()
    {
        //$this->middleware(checkPermissions::class.":view-discount")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-discount")->only(['store']);
        $this->middleware(checkPermissions::class.":update-discount")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-discount")->only(['delete']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDiscountRequest $request
     * @return DiscountResource
     */
    public function store(StoreDiscountRequest $request, $product_id): DiscountResource
    {

        //store product in database
        $store = Discount::query()->create([
            'product_id' => $product_id,
            'value' => $request->get('value'),
        ]);
        //return discount
        return new DiscountResource($store);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Discount $discount
     *
     */
    public function show($product_id)
    {
        $product = Product::query()->where('id', $product_id)->firstOrFail();
        if (!$product->discount){
            return Response()->json(null,404);
        }

        $discount = $product->discount;
        return new DiscountResource($discount);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDiscountRequest $request
     * @param \App\Models\Discount $discount
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDiscountRequest $request,$product_id): \Illuminate\Http\JsonResponse
    {
        $product = Product::query()->where('id', $product_id)->firstOrFail();
        if (!$product->discount){
            return Response()->json(null,404);
        }

        $discount = $product->discount;

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
            'massage' => 'تخفیف محصول با موفقیت ویرایش شد'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Discount $discount
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($product_id): \Illuminate\Http\JsonResponse
    {
        $discount = Product::query()->where('id', $product_id)->firstOrFail()->discount;
        //delete discount from database
        $delete = $discount->delete();

        //return errors
        if (!$delete) {
            return response()->json([
                $delete->errors()
            ], 400);
        }

        return Response()->json([
            'massage' => 'تخفیف با موفقیت حذق شد'
        ], 200);
    }
}
