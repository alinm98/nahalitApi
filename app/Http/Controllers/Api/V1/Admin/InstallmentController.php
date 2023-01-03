<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InstallmentCollection;
use App\Http\Resources\V1\InstallmentResourcse;
use App\Models\Installment;
use App\Http\Requests\StoreInstallmentRequest;
use App\Http\Requests\UpdateInstallmentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\In;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return InstallmentCollection
     */
    public function index(): InstallmentCollection
    {
        return new InstallmentCollection(Installment::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInstallmentRequest $request
     * @return InstallmentResourcse
     */
    public function store(StoreInstallmentRequest $request)
    {
        $installment = Installment::query()->create([
            'price'=>$request->get('price'),
            'user_id'=>$request->get('user_id'),
            'order_id'=>$request->get('order_id'),
            'description'=>$request->get('description'),
            'number_of_installment'=>$request->get('number_of_installment'),
            'status'=>$request->get('status'),
            'payments'=>$request->get('payments'),
            'deadline'=>$request->get('deadline'),
        ]);
        return new InstallmentResourcse($installment);
    }

    /**
     * Display the specified resource.
     *
     * @param Installment $installment
     * @return InstallmentResourcse
     */
    public function show(Installment $installment)
    {
        return new InstallmentResourcse($installment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstallmentRequest  $request
     * @param Installment $installment
     * @return JsonResponse
     */
    public function update(UpdateInstallmentRequest $request, Installment $installment)
    {
        $update = $installment->update([
            'price'=>$request->get('price'),
            'user_id'=>$request->get('user_id'),
            'order_id'=>$request->get('order_id'),
            'description'=>$request->get('description'),
            'number_of_installment'=>$request->get('number_of_installment'),
            'status'=>$request->get('status'),
            'payments'=>$request->get('payments'),
            'deadline'=>$request->get('deadline'),
        ]);
        if (!$update){
            return response()->json([
                $update->errors()
            ],400);
        }

        return Response()->json([
            'massage' => 'updated successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Installment $installment
     * @return JsonResponse
     */
    public function destroy(Installment $installment): JsonResponse
    {
        $installment->delete();
        return response()->json([
            'message'=>'انجام شد'
        ]);
    }
}
