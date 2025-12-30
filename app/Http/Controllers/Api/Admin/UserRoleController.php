<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserUpdateRequest;
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

    public function show(User $user)
    {
        return response()->json([
            $user->load('roles')
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

    public function update(UserUpdateRequest $request, User $user)
    {   
        
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        $user->syncRoles([$request->role]);

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'user' => $user->load('roles')
        ], 200);

    }

    public function activate(User $user)
    {
        $user->active = true;
        $user->save();

        return response()->json([
            'message' => 'Usuario activado',
        ], 200);
    }

    public function deactivate(User $user)
    {
        $user->active = false;
        $user->save();

        return response()->json([
            'message' => 'Usuario desactivado',
        ], 200);
    }

    public function destroy(User $user){
    
    $user->syncRoles([]);
    $user->syncPermissions([]);

    $user->delete();

    return response()->json([
        'message' => 'Usuario eliminado correctamente',
        'user' => $user
    ]);
}

}
