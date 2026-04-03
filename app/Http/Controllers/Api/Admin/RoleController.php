<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\SyncPermissionsRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\ApiResponse;

class RoleController extends Controller

{
    
    use ApiResponse;

    public function index()
    {
        $roles = Role::with('permissions')->get();

        return $this->successResponse(
            'Roles obtenidos correctamente.',
            $roles,
            200
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());
        return response()->json($role, 201);
    }

    public function show(Role $role)
    {
        return response()->json($role->load('permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role eliminado correctamente']);
    }

    public function syncPermissions(SyncPermissionsRequest $request, Role $role)
    {
        $role->syncPermissions($request->permissions);
        return response()->json([
            'message' => 'Permisos sincronizados correctamente',
            'role' => $role->load('permissions')
        ]);
    }
}
