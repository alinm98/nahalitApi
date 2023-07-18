<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Resources\v1\RecruitmentCollection;
use App\Http\Resources\v1\RecruitmentResource;
use App\Models\Recruitment;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{

    private Recruitment $model;

    public function __construct()
    {
        $this->model = new Recruitment();

        $this->middleware(checkPermissions::class.":view-recruitment")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-recruitment")->only(['store']);
        $this->middleware(checkPermissions::class.":update-recruitment")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-recruitment")->only(['delete']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():RecruitmentCollection
    {

        /* Get All Recruitments */
        $recruitments = $this->model->all();
        /* Get All Recruitments */

        return new RecruitmentCollection($recruitments);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Recruitment $recruitment):RecruitmentResource
    {
        return new RecruitmentResource($recruitment);
    }

}
