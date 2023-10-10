<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\V1\OrderCollection;
use App\Http\Resources\V1\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    private Order $model;

    public function __construct()
    {
        $this->model = new Order();

        $this->middleware(checkPermissions::class.":view-order")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-order")->only(['store']);
        $this->middleware(checkPermissions::class.":update-order")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-order")->only(['delete']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response|OrderCollection
    {
        /* Return Response */
        return new OrderCollection(Order::all());
        /* Return Response */

    }

    public function store(StoreOrderRequest $request): \Illuminate\Http\JsonResponse
    {

        //dd($request->get('products'));
        $order = Order::query()->create([
            'status' => null,
            'total' => $request->get('total'),
            'user_id' => $request->get('user_id')
        ]);

        $products = $order->product()->attach($request->get('products'));



        return Response()->json([
            'order' => $order,
        ],201);
    }

    public function show(Order $order): \Illuminate\Http\JsonResponse
    {
        return Response()->json([
            'order' => new OrderResource($order),
            'products' => $order->product,
        ],200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order): \Illuminate\Http\Response
    {
        $order->product()->detach();

        $order->delete();

        return response([
            'message' => 'حذف با موفقیت انجام شد'
        ], 200);

    }


}
