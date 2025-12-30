<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return response()->json(Permission::orderBy('name')->get(), 200);
    }

    public function store(StorePermissionRequest $request)
    {
        
        $permission = Permission::create($request->validated());

        return response()->json($permission, 201);
    }

    public function show(Permission $permission)
    {
        return response()->json($permission, 200);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        
        $permission->update($request->validated());

        return response()->json($permission, 200);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => 'Permission deleted'], 200);
    }
}
