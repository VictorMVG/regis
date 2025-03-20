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
        // usuario autenticado
        $user = auth()->user();

        $companies = Company::all();

        // Verificar si el usuario tiene el rol ADMINISTRADOR DE SEDE
        if ($user->hasRole('ADMINISTRADOR DE SEDE')) {
            // Filtrar los headquarters por el company_id del usuario autenticado
            $headquarters = Headquarter::with('company')
                ->where('company_id', $user->company_id)
                ->get();
        } else {
            // Si no tiene el rol ADMINISTRADOR DE SEDE, obtener todos los headquarters
            $headquarters = Headquarter::with('company')->get();
        }

        return view('configuracion.usuarios.usuario.create', compact('companies', 'headquarters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'company_id' => ['nullable', 'exists:companies,id'], // company_id puede ser nulo
            'headquarter_id' => ['nullable', 'exists:headquarters,id'], // headquarter_id puede ser nulo
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'name' => ['required', 'string', 'max:100'],
        ])->validate();

        DB::beginTransaction();

        try {
            // Crear los estados si no existen
            if (Status::count() == 0) {
                Status::firstOrCreate(['name' => 'ACTIVO (A)']);
                Status::firstOrCreate(['name' => 'INACTIVO (A)']);
            }

            // Crear el usuario
            $user = User::create([
                'company_id' => $request->input('company_id'),
                'headquarter_id' => $request->input('headquarter_id'),
                'status_id' => Status::where('name', 'ACTIVO (A)')->first()->id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            // Asignar roles según los valores de company_id y headquarter_id
            $rolesToAssign = [];

            if ($request->filled('company_id')) {
                // Si tiene company_id, asignar el rol ADMINISTRADOR DE SEDE
                $adminSedeRole = Role::firstOrCreate(['name' => 'ADMINISTRADOR DE SEDE']);
                $rolesToAssign[] = $adminSedeRole->id;
            }

            if ($request->filled('headquarter_id')) {
                // Si tiene headquarter_id, asignar el rol GUARDIA
                $guardRole = Role::firstOrCreate(['name' => 'GUARDIA']);
                $rolesToAssign[] = $guardRole->id;
            }

            // Asignar los roles al usuario
            if (!empty($rolesToAssign)) {
                $user->roles()->sync($rolesToAssign);
            } else {
                // Si no tiene company_id ni headquarter_id, asignar un rol predeterminado (opcional)
                $defaultRole = Role::firstOrCreate(['name' => 'SIN ROL ASIGNADO']);
                $user->assignRole($defaultRole);
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
        $authUser = auth()->user();

        // Verificar si el usuario autenticado tiene el rol ADMINISTRADOR DE SEDE
        if ($authUser->hasRole('ADMINISTRADOR DE SEDE')) {
            // Verificar si el usuario relacionado tiene una sede y una empresa asociada
            if (!$user->headquarter || !$user->headquarter->company || $authUser->company_id != $user->headquarter->company->id) {
                abort(404); // Si no coincide la empresa o faltan relaciones, devolver error 404
            }
        };

        // Validar que un usuario que no sea SUPER USUARIO no pueda editar a un SUPER USUARIO
        if (!$authUser->hasRole('SUPER USUARIO') && $user->hasRole('SUPER USUARIO')) {
            abort(404);
        }

        $companies = Company::all();
        $statuses = Status::all();
        $roles = Role::where('name', '!=', 'SUPER USUARIO')->get();


        if ($authUser->hasRole('ADMINISTRADOR DE SEDE')) {
            $headquarters = Headquarter::with('company')
                ->where('company_id', $authUser->company_id)
                ->get();
        } else {
            // Si no tiene el rol ADMINISTRADOR DE SEDE, obtener todos los headquarters
            $headquarters = Headquarter::with('company')->get();
        };


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
            'roles' => ['nullable', 'array'], // Permitir que roles sea nulo
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

            // Sincronizar roles solo si se proporcionan
            if (!empty($validatedData['roles'])) {
                // Obtener el rol SUPER USUARIO
                $superUserRole = Role::where('name', 'SUPER USUARIO')->first();

                $roles = $validatedData['roles'];

                // Si el usuario tiene el rol SUPER USUARIO, asegúrate de que no se quite
                if ($user->hasRole('SUPER USUARIO') && $superUserRole) {
                    $roles[] = $superUserRole->id;
                }

                $user->roles()->sync($roles);
            }

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
        //usuari autenticado
        $authUser = auth()->user();

        // Validar que el usuario autenticado no se quiera eliminar a si mismo
        if ($authUser->id == $user->id) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'No puedes eliminarte a ti mismo',
                'icon' => 'error',
            ]));

            return redirect()->route('users.index');
        }

        if (!$authUser->hasRole('SUPER USUARIO') && $user->hasRole('SUPER USUARIO')) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'No tienes permiso para eliminar un SUPER USUARIO',
                'icon' => 'error',
            ]));

            return redirect()->route('users.index');
        }

        try {

            // Eliminar el usuario
            $user->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Usuario eliminado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar el Usuario. ' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->route('users.index');
    }
}
