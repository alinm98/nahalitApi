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

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $recruitment = Recruitment::query()->create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'birthday' => $request->get('birthday'),
            'martial_status' => $request->get('martial_status'),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'activity' => $request->get('activity'),
            'eduction_status' => $request->get('eduction_status'),
            'ability_description' => $request->get('ability_description'),
            'shaba_number' => $request->get('shaba_number'),
            'status' => $request->get('status'),
        ]);

        return Response()->json([
            'massage' => 'فرم شما با موفقیت ثبت شد',
            'data' => $recruitment
        ], 201);
    }

}
