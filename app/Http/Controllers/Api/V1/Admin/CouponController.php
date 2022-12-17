<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Resources\v1\CouponCollection;
use App\Http\Resources\v1\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = new Coupon();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /* Get All Coupons */
        $coupons = $this->model->all();
        /* Get All Coupons */

        return new CouponCollection($coupons);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponRequest $request)
    {

        $data = $request->all();

        /* Store Coupon */
        $coupon = $this->model->create($data);
        /* Store Coupon */

        /* Return Response */
        return new CouponResource($coupon);
        /* Return Response */

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponRequest $request, $id)
    {

        /**
         * !!!! Note !!!!
         *
         * In Form Data Should Place '_method' Field With 'Value'
         *
         */

        $newData = $request->all();

        $coupon = $this->model->where('id', $id)->first();

        /* Check Coupon Exists */
        if(!$coupon){
            return response([
                'result' => false,
                'message' => 'کد تخفیف پیدا نشد'
            ], 404);
        }
        /* Check Coupon Exists */

        /* Update Coupon */
        $res = $coupon->update([
            'coupon_type' => $request->coupon_type,
            'coupon_value' => $request->coupon_value,
            'user_id' => $request->user_id
        ]);
        /* Update Coupon */

        /* Return Response */
        return response([
            'result' => true,
            'message' => 'با موفقیت اپدیت شد'
        ], 200);
        /* Return Response */

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $coupon = $this->model->where('id', $id)->first();

        /* Check Exists Coupon */
        if(!$coupon){
            return response([
                'result' => false,
                'message' => 'کد تخفیف پیدا نشد'
            ], 404);
        }
        /* Check Exists Coupon */

        /* Delete Coupon */
        $res = $coupon->delete();
        /* Delete Coupon */

        /* Check Coupon Deleted */
        if(!$res){
            return response([
                'result' => false,
                'message' => 'خطا در انجام عملیات'
            ], 400);
        }
        /* Check Coupon Deleted */

        /* Return Response */
        return response([
            'result' => true,
            'message' => 'با موفقیت حذف شد'
        ], 200);
        /* Return Response */

    }
}
