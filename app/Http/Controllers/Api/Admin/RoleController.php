<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\SyncPermissionsRequest;
use App\Http\Resources\RolesResource;
use App\Http\Resources\ShowRoleResource;
use App\Models\Role;
use App\Traits\ApiResponse;

class RoleController extends Controller

{
    
    use ApiResponse;

    public function index(Request $request)
    {
        $search = $request->query('search');

        $roles = Role::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })->orderBy('name')->paginate(10);

        $data = RolesResource::collection($roles->items());
    
        return $this->successResponse(
            'Roles obtenidos correctamente.',
            $data,
            200,
            [
                'pagination' => [
                    'total'       => $roles->total(),
                    'perPage'     => $roles->perPage(),
                    'currentPage' => $roles->currentPage(),
                    'lastPage'    => $roles->lastPage(),
                ]
            ]
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());
        return response()->json($role, 201);
    }

    public function show(Role $role)
    {
        return $this->successResponse('Rol encontrado.', new  ShowRoleResource($role));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return response()->json($role);
    }

    public function activate(Role $role)
    {
        $role->update(['active' => !$role->active]);

        $data = [
            'id' => $role->id,
            'active' => $role->active,
        ];

        $message = $role->active ? 'Rol activado correctamente.' : 'Rol desactivado correctamente.';

        return $this->successResponse($message, $data);
    }

    public function destroy(Role $role)
    {
        
        if (!$role->canBeDeleted()) {

            return $this->errorResponse('Hubo un error al eliminar el rol.', ['name' => ['Este rol está en uso. Desactívalo en lugar de borrarlo.']], 422);

        }
        
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
