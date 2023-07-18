<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Resources\v1\OrderCollection;
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
    public function index(Request $request): \Illuminate\Http\Response|OrderCollection
    {

        $sent = false;
        /* Determine Sent Status */
        if($request->has('sent')){
            if($request->input('sent') == 'true'){
                $sent = true;
            }
        };
        /* Determine Sent Status */

        /* Get All Orders */
        $orders = $this->model->where('status', $sent ? 'sent' : 'notsent')->get();
        /* Get All Orders */

        /* Return Response */
        return new OrderCollection($orders);
        /* Return Response */

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request): \Illuminate\Http\Response
    {

        $sent = false;
        /* Determine Sent Status */
        if($request->has('sent')){
            if($request->input('sent') == 'true'){
                $sent = true;
            }
        };
        /* Determine Sent Status */

        $orders = $this->model->where('status', $sent ? 'sent' : 'notsent')->get();

        foreach ($orders as $order){
            $res = $order->delete();
            if(!$res){
                return response([
                    'result' => false,
                    'message' => 'خطا در انجام عملیات'
                ], 500);
            }
        }

        return response([
            'result' => true,
            'message' => 'با موفقیت انجام شد'
        ], 200);

    }

    /**
     * Confirm Orders.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmOrder($id): \Illuminate\Http\Response
    {
        $order = $this->model->where('id', $id)->first();

        /* Check Order Exists */
        if(!$order){
            return response([
                'result' => false,
                'message' => 'سفارش پیدا نشد'
            ], 404);
        }
        /* Check Order Exists */

        /* Update Order */
        $res = $order->update([
            'confirm' => true
        ]);
        /* Update Order */

        /* Check Order Updated */
        if(!$res){
            return response([
                'result' => false,
                'message' => 'خطا در انجام عملیات'
            ], 500);
        }
        /* Check Order Updated */

        /* Return Response */
        return response([
            'result' => true,
            'message' => 'با موفقیت تایید شد'
        ], 200);
        /* Return Response */

    }
}
