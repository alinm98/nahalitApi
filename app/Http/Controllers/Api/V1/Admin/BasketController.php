<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBasketRequest;
use App\Http\Requests\UpdateBasketRequest;
use App\Http\Resources\V1\BasketCollection;
use App\Http\Resources\V1\BasketResource;
use App\Models\Basket;
use App\Models\User;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BasketCollection
     */
    public function index(): BasketCollection
    {
        return new BasketCollection(Basket::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreBasketRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBasketRequest $request)
    {
        $basket = Basket::query()->create([
            'user_id' => $request->get('user_id'),
            'product_id' => $request->get('product_id'),
        ]);

        return response()->json([
            'massage' => 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد',
            'basket' => new BasketResource($basket)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Basket $basket
     * @return BasketCollection
     */
    public function show($id): BasketCollection
    {
        $user = User::query()->where('id' , $id)->firstOrFail();

        return new BasketCollection($user->baskets);
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Basket $basket
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Basket $basket)
    {
        $basket->delete();

        return response()->json([
            'massage' => 'محصول مورد نظر با موفقیت از سبد خرید حذف شد',
        ]);
    }
}
