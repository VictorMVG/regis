<?php

namespace App\Http\Controllers\Configuracion\Usuarios\Catalogos;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('configuracion.usuarios.catalogos.permiso.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('configuracion.usuarios.catalogos.permiso.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'roles' => 'required|array', // Validar que roles sea un array
            'roles.*' => 'integer|exists:roles,id', // Validar que cada rol sea un entero y exista en la tabla roles
        ]);

        try {
            // Crear el permiso
            $permission = Permission::create($request->only('name'));

            // Asignar el permiso a los roles seleccionados
            if ($request->has('roles')) {
                $roles = Role::whereIn('id', $request->roles)->get();
                foreach ($roles as $role) {
                    $role->givePermissionTo($permission);
                }
            }

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Permiso creado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear el permiso.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('permissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $roles = Role::all();
        return view('configuracion.usuarios.catalogos.permiso.edit', compact('permission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'roles' => 'required|array', // Validar que roles sea un array
            'roles.*' => 'integer|exists:roles,id', // Validar que cada rol sea un entero y exista en la tabla roles
        ]);

        try {
            // Actualizar el permiso
            $permission->update($request->only('name'));

            // Sincronizar los roles
            if ($request->has('roles')) {
                $roles = Role::whereIn('id', $request->roles)->get();
                foreach ($roles as $role) {
                    $role->givePermissionTo($permission);
                }
            }

            // Eliminar permisos de roles no seleccionados
            $permission->roles()->whereNotIn('id', $request->roles)->each(function ($role) use ($permission) {
                $role->revokePermissionTo($permission);
            });

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Permiso actualizado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar el permiso.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Permiso eliminado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar el permiso.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('permissions.index');
    }
}
