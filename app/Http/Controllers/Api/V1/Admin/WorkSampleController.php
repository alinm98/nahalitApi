<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkSampleRequest;
use App\Http\Requests\UpdateWorkSampleRequest;
use App\Http\Resources\v1\WorkSampleCollection;
use App\Http\Resources\v1\WorkSampleResource;
use App\Models\WorkSample;
use Illuminate\Http\Request;

class WorkSampleController extends Controller
{

    private WorkSample $model;

    public function __construct()
    {
        $this->model = new WorkSample();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():WorkSampleCollection
    {

        /* Get All WorkSamples */
        $workSamples = $this->model->all();
        /* Get All WorkSamples */

        return new WorkSampleCollection($workSamples);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkSampleRequest $request):WorkSampleResource
    {

        $data = $request->all();

        /* Store Work Sample */
        $workSample = $this->model->create($data);
        /* Store Work Sample */

        return new WorkSampleResource($workSample);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkSampleRequest $request, WorkSample $workSample)
    {

        $newData = $request->all();

        /* Update Work Sample */
        $res = $workSample->update($newData);
        /* Update Work Sample */

        /* Check Work Sample Updated */
        if(!$res){
            return response([
                'result' =>false,
                'message' => 'خطا در انجام عملیات'
            ], 500);
        }
        /* Check Work Sample Updated */

        return response([
            'result' => true,
            'message' => 'با موفقیت اپدیت شد'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkSample $workSample)
    {

        /* Delete Work Sample */
        $res = $workSample->delete();
        /* Delete Work Sample */

        /* Check Work Sample Deleted */
        if(!$res){
            return response([
                'result' => false,
                'message' => 'خطا در انجام عملیات'
            ], 500);
        }
        /* Check Work Sample Deleted */

        return response([
            'result' => true,
            'message' => 'با موفقیت حذف شد'
        ], 200);

    }
}
