<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Resources\v1\CouponCollection;
use App\Http\Resources\v1\CouponResource;
use App\Http\Resources\V1\ProductResource;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    private Coupon $model;

    public function __construct()
    {
        $this->model = new Coupon();

        $this->middleware(checkPermissions::class.":view-coupon")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-coupon")->only(['store']);
        $this->middleware(checkPermissions::class.":update-coupon")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-coupon")->only(['delete']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return CouponCollection
     */
    public function index(): CouponCollection
    {

        /* Get All Coupons */
        $coupons = $this->model->all();
        /* Get All Coupons */

        return new CouponCollection($coupons);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Coupon $coupon
     * @return CouponResource
     */
    public function show(Coupon $coupon): CouponResource
    {
        return new CouponResource($coupon);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CouponResource
     */
    public function store(StoreCouponRequest $request): CouponResource
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
    public function destroy($id): \Illuminate\Http\Response
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
