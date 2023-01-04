<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIpRequest;
use App\Http\Requests\UpdateIpRequest;
use App\Http\Resources\V1\IpCollection;
use App\Http\Resources\V1\IpResource;
use App\Models\Ip;

class IpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'ips' => new IpCollection(Ip::all()),
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIpRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreIpRequest $request): \Illuminate\Http\JsonResponse
    {
        $store = Ip::query()->create([
            'ip' => $request->get('ip'),
            'route' => $request->get('route'),
            'user_id' => $request->get('user_id'),
            'status' => $request->get('status'),
        ]);

        return response()->json([
            'status' => true,
            'ip' => new IpResource($store)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Ip $ip)
    {
        return response()->json([
            'ip' => new IpResource($ip)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIpRequest  $request
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateIpRequest $request, Ip $ip): \Illuminate\Http\JsonResponse
    {
        $update = $ip->update([
            'status' => $request->get('status')
        ]);


        //return errors
        if (!$update) {
            return response()->json([
                'status' => false,
                'massage' => 'خطایی در عملیات بروزرسانی رخ داده است'
            ], 400);
        }

        return Response()->json([
            'status' => true,
            'massage' => 'بروزرسانی با موفقیت انجام شد'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ip  $ip
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Ip $ip)
    {
        $delete = $ip->delete();

        if (!$delete) {
            return response()->json([
                'status' => false,
                'massage' => 'خطایی در عملیات حذف رخ داده است'
            ], 400);
        }


        return Response()->json([
            'status' => true,
            'massage' => 'حذف با موفقیت انجام شد'
        ], 200);
    }
}
