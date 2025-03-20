<?php

namespace App\Http\Controllers\Configuracion\Usuarios\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Catalogos\Status;
use App\Models\Configuracion\Usuarios\Catalogos\Company;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use Illuminate\Http\Request;

class HeadquarterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('configuracion.usuarios.catalogos.sede.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener el ID del estado "ACTIVO (A)"
        $activeStatusId = Status::where('name', 'ACTIVO (A)')->value('id');

        $companies = Company::where('status_id', $activeStatusId)->get();

        return view('configuracion.usuarios.catalogos.sede.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //usuario autenticado
        $user = auth()->user();

        //validar que el usuario autenticado tenga company_id asignado si su rol es ADMINISTRADOR DE SEDE
        if ($user->hasRole('ADMINISTRADOR DE SEDE') && !$user->company_id) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'No tienes una empresa asignada, contacta al administrador del sistema.',
                'icon' => 'error',
            ]));

            return redirect()->route('headquarters.index');
        }

        //validar que si el usuario autenticado tiene el rol ADMINISTRADOR DE SEDE

        $request->validate([
            'company_id' => 'nullable|integer|exists:companies,id',
            'name' => 'required|string|max:255|unique:headquarters,name,NULL,id,company_id,' . $request->company_id,
        ]);

        try {
            $request->merge(['company_id' => $user->hasRole('ADMINISTRADOR DE SEDE') ? $user->company_id : $request->company_id]);

            Headquarter::create($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Sede creada correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('headquarters.index');
        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear la sede.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('headquarters.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Headquarter $headquarter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Headquarter $headquarter)
    {
        $user = auth()->user();

        if ($user->hasRole('ADMINISTRADOR DE SEDE') && $headquarter->company_id != $user->company_id) {
            abort(404);
        }

        // Obtener el ID del estado "ACTIVO (A)"
        $activeStatusId = Status::where('name', 'ACTIVO (A)')->value('id');

        $statuses = Status::all();
        $companies = Company::where('status_id', $activeStatusId)->get();

        return view('configuracion.usuarios.catalogos.sede.edit', compact('headquarter', 'statuses', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Headquarter $headquarter)
    {
        $request->validate([
            'company_id' => 'nullable|integer|exists:companies,id',
            'name' => 'required|string|max:255|unique:headquarters,name,' . $headquarter->id . ',id,company_id,' . ($request->company_id ?? $headquarter->company_id),
            'status_id' => 'required|exists:statuses,id',
        ]);

        try {
            // Si company_id viene vacío, mantener el valor actual del registro
            $request->merge([
                'company_id' => $request->company_id ?? $headquarter->company_id,
            ]);

            $headquarter->update($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Sede actualizada correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('headquarters.index');
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar la sede.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('headquarters.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Headquarter $headquarter)
    {
        try {

            $headquarter->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Sede eliminada correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('headquarters.index');
        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar la sede.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('headquarters.index');
    }
}
