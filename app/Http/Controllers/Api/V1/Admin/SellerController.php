<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\StoreSellerRequest;
use App\Http\Resources\V1\SellerCollection;
use App\Http\Resources\v1\SellerResource;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{

    private Seller $model;

    public function __construct()
    {
        $this->model = new Seller();

        $this->middleware(checkPermissions::class.":view-seller")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-seller")->only(['store']);
        $this->middleware(checkPermissions::class.":update-seller")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-seller")->only(['delete']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():SellerCollection
    {

        /* Get All Sellers */
        $sellers = $this->model->all();
        /* Get All Sellers */

        return new SellerCollection($sellers);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(StoreSellerRequest $request): \Illuminate\Http\JsonResponse
    {
        $sellerExists = Seller::query()->where('user_id',$request->get('user_id'))->firstOrFail()->exists();
        if ($sellerExists){
            return Response()->json([
                'massage' => 'این کاربر قبلا به عنوان فروشنده ثبت شده است'
            ],403);
        }
        $data = $request->all();

        /* Validate Is_Active Field */
        if($request->has('status')){
            $data['status'] = true;
        }else{
            $data['status'] = false;
        }
        /* Validate Is_Active Field */

        /* Store Seller */
        $seller = $this->model->create($data);
        /* Store Seller */

        return Response()->json([
            'seller' => new SellerResource($seller)
        ],403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller):SellerResource
    {

        return new SellerResource($seller);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {

        /* Check Seller Exists */
        if(!$seller){
            return response([
                'result' => false,
                'message' => 'فروشنده پیدا نشد'
            ], 404);
        }
        /* Check Seller Exists */

        /* Delete Seller */
        $res = $seller->delete();
        /* Delete Seller */

        return response([
            'result' => true,
            'message' => 'با موفقیت حذف شد'
        ], 200);

    }
}
