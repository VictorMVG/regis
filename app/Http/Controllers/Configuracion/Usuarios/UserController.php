<?php

namespace App\Http\Controllers\Configuracion\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Catalogos\Status;
use App\Models\Configuracion\Usuarios\Catalogos\Company;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Actions\Fortify\PasswordValidationRules;
use Laravel\Jetstream\Jetstream;

class UserController extends Controller
{
    use PasswordValidationRules;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('configuracion.usuarios.usuario.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $headquarters = Headquarter::with('company')->get();

        return view('configuracion.usuarios.usuario.create', compact('companies', 'headquarters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'company_id' => ['exists:companies,id'],
            'headquarter_id' => ['required', 'exists:headquarters,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'name' => ['required', 'string', 'max:100'],
        ])->validate();

        DB::beginTransaction();

        try {

            if (Status::count() == 0) {
                Status::firstOrCreate(['name' => 'ACTIVO (A)']);
                Status::firstOrCreate(['name' => 'INACTIVO (A)']);
            }

            $user = User::create([
                'company_id' => $request['company_id'],
                'headquarter_id' => $request['headquarter_id'],
                'status_id' => Status::where('name', 'ACTIVO (A)')->first()->id,
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            if (User::count() == 1) {
                // Crear el rol ADMIN si no existe
                $adminRole = Role::firstOrCreate(['name' => 'SUPER USUARIO']);
                // Asignar el rol ADMIN al primer usuario
                $user->assignRole($adminRole);
            } else {
                // Crear el rol GUARDIA si no existe
                $guardRole = Role::firstOrCreate(['name' => 'GUARDIA']);
                // Asignar el rol GUARDIA al nuevo usuario
                $user->assignRole($guardRole);
            }

            DB::commit();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Usuario creado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear el Usuario. ' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('configuracion.usuarios.usuario.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $companies = Company::all();
        $statuses = Status::all();
        $roles = Role::where('name', '!=', 'SUPER USUARIO')->get();
        $headquarters = Headquarter::with('company')->get();

        return view('configuracion.usuarios.usuario.edit', compact('user', 'companies', 'statuses', 'roles', 'headquarters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'status_id' => ['required', 'exists:statuses,id'],
            'company_id' => ['nullable', 'exists:companies,id'],
            'headquarter_id' => ['required', 'exists:headquarters,id'],
            'password' => ['nullable', 'string', 'min:8'],
            'name' => ['required', 'string', 'max:100'],
            'roles' => ['required', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        DB::beginTransaction();

        try {
            // Actualizar los datos básicos del usuario
            $user->email = $validatedData['email'];
            $user->status_id = $validatedData['status_id'];
            $user->company_id = $validatedData['company_id'] ?? null;
            $user->headquarter_id = $validatedData['headquarter_id'];
            $user->name = $validatedData['name'];

            // Actualizar la contraseña si se proporciona
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();

            // Obtener el rol SUPER USUARIO
            $superUserRole = Role::where('name', 'SUPER USUARIO')->first();

            // Sincronizar roles
            $roles = $validatedData['roles'];

            // Si el usuario tiene el rol SUPER USUARIO, asegúrate de que no se quite
            if ($user->hasRole('SUPER USUARIO') && $superUserRole) {
                $roles[] = $superUserRole->id;
            }

            $user->roles()->sync($roles);

            DB::commit();

            // Mensaje de éxito
            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Usuario actualizado correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('users.index');
        } catch (\Exception $e) {
            DB::rollBack();

            // Mensaje de error
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar el Usuario. ' . $e->getMessage(),
                'icon' => 'error',
            ]));

            return redirect()->route('users.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {
            // Eliminar el usuario
            $user->delete();

            DB::commit();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Usuario eliminado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar el Usuario. ' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->route('users.index');
    }
}
