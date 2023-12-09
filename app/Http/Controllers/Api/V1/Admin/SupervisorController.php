<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChoiceRecruitmentRequest;
use App\Models\Project;
use App\Models\Role;
use App\Models\Supervisor;
use App\Models\User;
use http\Env\Response;

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

    public function choiceRecruitment(ChoiceRecruitmentRequest $request,User $user): \Illuminate\Http\JsonResponse
    {
        $status = $request->get('status');
        $recruitment = $user->recruitment();
        $role = Role::query()->where('title', 'کارمند')->firstOrFail();

        if ($status == 'accepted'){
            $user->update([
                'role_id' => $role->id
            ]);

            $recruitment->update([
                'status' => $status
            ]);

            return response()->json([
                'massage' => 'کاربر با موفقیت استخدام شد'
            ], 200);
        }

        $recruitment->update([
            'status' => $status
        ]);

        return response()->json([
            'massage' => 'متاسفانه کاربر استخدام نشد'
        ],200);
    }

    public function choiceSupervisor(User $user): \Illuminate\Http\JsonResponse
    {
        $supervisor_role_id = Role::query()->where('title', 'سرپرست')->firstOrFail()->id;

        $user->update([
            'role_id' => $supervisor_role_id
        ]);

        return response()->json([
            'massage' => 'کاربر با موفقیت سرپرست شد'
        ],200);
    }

    public function recruitmentProperties(User $user): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'properties' => $user->recruitment
        ], 200);
    }

    public function getSupervisorProjects(User $user): \Illuminate\Http\JsonResponse
    {
        $supervisor_role_id = Role::query()->where('title', 'سرپرست')->firstOrFail()->id;
        if ($user->role->id != $supervisor_role_id){
            return response()->json([
                'massage' => 'کاربر مورد نظر سرپرست نیست'
            ],403);
        }

        $projects = Project::query()->where('supervisor_id', $user->id)->get();

        return response()->json([
            'projects' => $projects
        ],200);
    }

    public function setSupervisorProject(User $user, Project $project): \Illuminate\Http\JsonResponse
    {
        $supervisor_role_id = Role::query()->where('title', 'سرپرست')->firstOrFail()->id;
        if ($user->role->id != $supervisor_role_id){
            return response()->json([
                'massage' => 'کاربر مورد نظر سرپرست نیست'
            ],403);
        }

        $project->update([
            'supervisor_id' => $user->id
        ]);

        $massage = 'پروژه با موفقیت به سرپرست '.$user->first_name.' '.$user->last_name.' داده شد.';
        return response()->json([
            'massage' => $massage
        ],200);
    }
}
