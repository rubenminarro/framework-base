<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\AssignRoleRequest;
use App\Models\User;


class UserRoleController extends Controller
{
    // Listar usuarios con roles y permisos
    public function index()
    {
        return response()->json([
            User::with(['roles'])->get()
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        if ($request->role) {
            $user->assignRole($request->role);
        }

        return response()->json([
            'message' => 'Usuario creado con éxito',
            'user' => $user->load('roles'),
        ], 201);
    }

    public function assignRole(AssignRoleRequest $request, $id)
    {   
        $rol = $request->validated();
        
        $user = User::findOrFail($id);

        $user->syncRoles([$request->role]);

        return response()->json([
            'message' => 'Rol asignado correctamente',
            'user' => $user->load('roles'),
        ]);
    }

}
