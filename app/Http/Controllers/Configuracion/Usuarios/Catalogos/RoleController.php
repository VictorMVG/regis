<?php

namespace App\Http\Controllers\Configuracion\Usuarios\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('configuracion.usuarios.catalogos.rol.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('configuracion.usuarios.catalogos.rol.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array', // Validar que permissions sea un array
            'permissions.*' => 'integer|exists:permissions,id', // Validar que cada permiso sea un entero y exista en la tabla permissions
        ]);

        try {
            // Crear el rol
            $role = Role::create($request->only('name'));

            // Asignar los permisos al rol seleccionados
            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                foreach ($permissions as $permission) {
                    $role->givePermissionTo($permission);
                }
            }

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Rol creado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear el rol.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('configuracion.usuarios.catalogos.rol.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'required|array', // Validar que permissions sea un array
            'permissions.*' => 'integer|exists:permissions,id', // Validar que cada permiso sea un entero y exista en la tabla permissions
        ]);

        try {
            // Actualizar el rol
            $role->update($request->only('name'));

            // Sincronizar los permisos
            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                $role->syncPermissions($permissions);
            } else {
                // Si no se seleccionaron permisos, eliminar todos los permisos del rol
                $role->syncPermissions([]);
            }

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Rol actualizado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar el rol.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Rol eliminado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar el rol.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('roles.index');
    }
}
