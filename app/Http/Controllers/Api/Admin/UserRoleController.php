<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Traits\ApiResponse;


class UserRoleController extends Controller
{
    use ApiResponse;
    
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        return $this->successResponse(
            'Usuarios obtenidos correctamente.',
            $users->items(),
            200,
            [
                'pagination' => [
                    'total'       => $users->total(),
                    'perPage'     => $users->perPage(),
                    'currentPage' => $users->currentPage(),
                    'lastPage'    => $users->lastPage(),
                ]
            ]
        );
    }

    public function show(User $user)
    {
        return $this->successResponse('Usuario encontrado.', $user->load('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        if ($request->role) {
            $user->assignRole($request->role);
        }

        return $this->successResponse('Usuario creado correctamente.', $user->load('roles'), 201);

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

        return $this->successResponse('Usuario actualizado correctamente.', $user->load('roles'));

    }

    public function activate(User $user)
    {
        $user->active = true;
        $user->save();

        return $this->successResponse('Usuario activado.', ['id' => $user->id, 'active' => true]);

    }

    public function deactivate(User $user)
    {
        $user->active = false;
        $user->save();

        return $this->successResponse('Usuario desactivado.', ['id' => $user->id, 'active' => false]);

    }

    public function destroy(User $user){
    
        $user->syncRoles([]);
        $user->syncPermissions([]);

        $user->delete();

        return $this->successResponse('Usuario eliminado correctamente.', ['user' => $user]);

    }

}
