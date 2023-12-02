<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Supervisor;
use App\Models\User;

class SupervisorController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $supervisor_role_id = Role::query()->where('title', 'سرپرست')->firstOrFail()->id;
        $supervisors = User::query()->where('role_id', $supervisor_role_id)->get()->all();
        return response()->json([
            'supervisors' => $supervisors
        ],200);
    }

    public function projects(Supervisor $supervisor): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'projects' => $supervisor->projects()
        ],200);
    }

    public function choiceRecruitment()
    {

    }
}
