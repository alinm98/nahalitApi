<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\storeRecruitmentRequest;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {

        /* Get All Recruitments */
        $recruitments = $this->model->all();
        /* Get All Recruitments */

        return response()->json([
            'recruitment' => new RecruitmentCollection(Recruitment::all())
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Recruitment $recruitment): \Illuminate\Http\JsonResponse
    {
        return response()->json(new RecruitmentResource($recruitment),200);
    }

    public function store(storeRecruitmentRequest $request): \Illuminate\Http\JsonResponse
    {
        $recruitment = Recruitment::query()->create([
            'birthday' => $request->get('birthday'),
            'martial_status' => $request->get('martial_status'),
            'address' => $request->get('address'),
            'activity' => $request->get('activity'),
            'eduction_status' => $request->get('eduction_status'),
            'ability_description' => $request->get('ability_description'),
            'shaba_number' => $request->get('shaba_number'),
            'status' => $request->get('status'),
            'card_number' => $request->get('card_number'),
            'code_melli' => $request->get('code_melli'),
            'user_id' => $request->get('user_id')
        ]);

        return Response()->json([
            'massage' => 'فرم شما با موفقیت ثبت شد',
            'recruitment' => $recruitment
        ], 201);
    }

}
