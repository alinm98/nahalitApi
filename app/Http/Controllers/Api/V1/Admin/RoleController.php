<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\checkPermissions;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\V1\PermissionCollection;
use App\Http\Resources\V1\PermissionResource;
use App\Http\Resources\V1\RoleCollection;
use App\Http\Resources\V1\RoleResource;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware(checkPermissions::class.":view-role")->only(['index', 'show']);
        $this->middleware(checkPermissions::class.":create-role")->only(['store']);
        $this->middleware(checkPermissions::class.":update-role")->only(['update']);
        $this->middleware(checkPermissions::class.":delete-role")->only(['delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return Response()->json([
            'roles' => new RoleCollection(Role::all()),
            'permissions' => new PermissionCollection(Permission::all())
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request): \Illuminate\Http\JsonResponse
    {
        $permissions = $request->get('permissions');

        $role = Role::query()->create([
            'title' => $request->get('title')
        ]);

        $role->permissions()->attach($permissions);

        return Response()->json([
            'status' => true,
            'role' => new RoleResource($role),
            'permissions' => $request->get('permissions')
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role): \Illuminate\Http\JsonResponse
    {
        return Response()->json([
            'status' => true,
            'role' => new RoleResource($role),
            'permissions' => new PermissionCollection($role->permissions)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): \Illuminate\Http\JsonResponse
    {
        //check for unique title
        $roleExist = Role::query()->where('title', $request->get('title'))
            ->where('id', '!=', $role->id)->exists();

        if ($roleExist) {
            return Response()->json([
                'error' => 'این عنوان اکنون وچود دارد'
            ], 400);
        }

        $update = $role->update([
            'title' => $request->get('title')
        ]);

        $role->permissions()->sync($request->get('permissions'));

        //return errors
        if (!$update) {
            return response()->json([
                'status' => false,
                'massage' => 'خطایی در عملیات بروزرسانی رخ داده است'
            ], 400);
        }

        return Response()->json([
            'status' => true,
            'massage' => 'بروزرسانی با موفقیت انجام شد'
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role): \Illuminate\Http\JsonResponse
    {
        $role->permissions()->detach();

        $role->delete();

        return Response()->json([
            'status' => true,
            'massage' => 'حذف با موفقیت انجام شد'
        ], 200);
    }
}
