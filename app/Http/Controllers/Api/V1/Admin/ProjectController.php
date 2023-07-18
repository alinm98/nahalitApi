<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Resources\v1\ProjectCollection;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    private Project $model;

    public function __construct()
    {
        $this->model = new Project();

        $this->middleware(checkPermissions::class.":view-project")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-project")->only(['store']);
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
}
