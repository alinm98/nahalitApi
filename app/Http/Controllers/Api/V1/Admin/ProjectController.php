<?php

namespace App\Http\Controllers\api\V1\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\storeProjectRequest;
use App\Http\Requests\updateProjectRequest;
use App\Http\Resources\V1\ProjectCollection;
use App\Models\Project;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{

    private Project $model;

    public function __construct()
    {
        $this->model = new Project();

        //$this->middleware(checkPermissions::class.":view-project")->only(['index', 'show']);
        //$this->middleware(checkPermissions::class.":create-project")->only(['store']);
        $this->middleware(checkPermissions::class.":update-project")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-project")->only(['delete']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():ProjectCollection
    {

        /* Get All Projects */
        $projects = $this->model->all();
        /* Get All Projects */

        return new ProjectCollection($projects);

    }

    public function store(storeProjectRequest $request): \Illuminate\Http\JsonResponse
    {


        $data = $request->all();

        if (!empty($request->file('file'))){
            $file = $request->file('file')->store('public/upload/projects');
            $file = str_replace('public', '/storage', $file);
            $data['file'] = url($file);
        }



        $project = $this->model->create($data);

        return Response()->json($project,201);
    }

    public function update(updateProjectRequest $request,Project $project): \Illuminate\Http\JsonResponse
    {

        //store new file(if exist)
        $data = $request->all();
        if ($request->file('file') != null) {
            $file = $project->file;
            Storage::delete($file);
            $file = $request->file('image')->store('public/upload/projects');
            $file = str_replace('public', '/storage', $file);
            $data['file'] = url($file);
        }
        
        $res = $project->update($data);

        return Response()->json([
            'پروزه با موفقیت بروزرسانی شد'
        ],201);
    }

    public function show(Project $project): \Illuminate\Http\JsonResponse
    {
        return Response()->json($project,200);
    }
}
