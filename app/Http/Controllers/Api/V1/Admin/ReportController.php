<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Resources\v1\ReportCollection;
use App\Http\Resources\v1\ReportResource;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{

    private Report $model;

    public function __construct()
    {
        $this->model = new Report();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():ReportCollection
    {

        /* Get All Reports */
        $reports = $this->model->all();
        /* Get All Reports */

        return new ReportCollection($reports);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request):ReportResource|\Illuminate\Http\Response
    {

        $data = $request->all();

        /* Store File */
        if($request->hasFile('file')){

            $file = $request->file('file');
            $path = $file->store('Project/Files');
            $data['file'] = $path;

        }else{
            return response([
                'result' => false,
                'message' => 'لطفا یک فایل را اپلود کنید'
            ], 422);
        }
        /* Store File */

        /* Store Data In DataBase */
        $report = $this->model->create($data);
        /* Store Data In DataBase */

        return new ReportResource($report);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, Report $report)
    {

        $newData = $request->all();

        /* Update File */
        if($request->hasFile('file')){

            /* Delete Old File */
            if($report->file){
                if(Storage::exists('Project/Files/' . $report->file)){
                    Storage::delete('Project/Files/' . $report->file);
                }
            }
            /* Delete Old File */

            /* Store New File */
            $file = $request->file('file');
            $path = $file->store('Project/Files');
            $newData['file'] = $path;
            /* Store New File */

        }
        /* Update File */

        /* Update Report */
        $res = $report->update($newData);
        /* Update Report */

        /* Check Updated Report */
        if(!$res){
            return response([
                'result' => false,
                'message' => 'خطا در انجام عملیات'
            ], 500);
        }
        /* Check Updated Report */

        return response([
            'result' => true,
            'message' => 'با موفقیت اپدیت شد'
        ], 200);

    }

}
