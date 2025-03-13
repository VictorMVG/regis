<?php

namespace App\Http\Controllers\Configuracion\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Catalogos\Status;
use App\Models\Configuracion\Usuarios\Catalogos\Company;
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

        return view('configuracion.usuarios.usuario.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'company_id' => ['required', 'exists:companies,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'name' => ['required', 'string', 'max:100'],
        ])->validate();

        DB::beginTransaction();

        try {

            $user = User::create([
                'company_id' => $request['company_id'],
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            if (Status::count() == 0) {
                Status::firstOrCreate(['name' => 'ACTIVO']);
                Status::firstOrCreate(['name' => 'INACTIVO']);
            }

            if (User::count() == 1) {
                // Crear el rol ADMIN si no existe
                $adminRole = Role::firstOrCreate(['name' => 'ADMIN']);
                // Asignar el rol ADMIN al primer usuario
                $user->assignRole($adminRole);
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

        return view('configuracion.usuarios.usuario.edit', compact('user', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Cargar explícitamente la relación userDetail
        $user->load('userDetail');

        Validator::make($request->all(), [
            'employee_number' => ['required', 'integer', 'min:1', 'unique:user_details,employee_number,' . $user->userDetail->user_id . ',user_id,company_id,' . $user->userDetail->company_id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'honorary_title_id' => ['required', 'exists:honorary_titles,id'],
            'name' => ['required', 'string', 'max:100'],
            'paternal_surname' => ['required', 'string', 'max:100'],
            'maternal_surname' => ['required', 'string', 'max:100'],
            'user_category_id' => ['required', 'exists:user_categories,id'],
            'blood_type_id' => ['nullable', 'exists:blood_types,id'],
            'rfc' => ['nullable', 'string', 'max:13', 'unique:user_details,rfc,' . $user->userDetail->user_id . ',user_id,company_id,' . $user->userDetail->company_id],
            'curp' => ['required', 'string', 'max:18', 'unique:user_details,curp,' . $user->userDetail->user_id . ',user_id,company_id,' . $user->userDetail->company_id],
            'nss' => ['nullable', 'string', 'max:11', 'unique:user_details,nss,' . $user->userDetail->user_id . ',user_id,company_id,' . $user->userDetail->company_id],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'allergies' => ['nullable', 'string', 'max:255'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:15'],
        ])->validate();

        DB::beginTransaction();

        try {
            // Actualizar el usuario
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->name = $request->name;
            $user->save();

            DB::commit();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Usuario actualizado correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar el Usuario. ' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->route('users.show', $user);
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
