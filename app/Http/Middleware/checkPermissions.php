<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;

class checkPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next, $param)
    {

        $permission = Permission::query()->where('title', $param)->firstOrFail();

        if (!auth()->user()->role->hasPermission($permission)){
            return Response()->json([
                'massage' => 'متاسفانه شما اجازه دسترسی به این بخش را ندارید'
            ],403);
        }

        return $next($request);
    }
}
