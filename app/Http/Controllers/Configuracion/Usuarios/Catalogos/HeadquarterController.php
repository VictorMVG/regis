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
        $companies = Company::all();
        return view('configuracion.usuarios.catalogos.sede.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer|exists:companies,id',
            'name' => 'required|string|max:255|unique:headquarters,name,NULL,id,company_id,' . $request->company_id,
        ]);

        try {

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
        $statuses = Status::all();
        $companies = Company::all();

        return view('configuracion.usuarios.catalogos.sede.edit', compact('headquarter', 'statuses', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Headquarter $headquarter)
    {
        $request->validate([
            'company_id' => 'required|integer|exists:companies,id',
            'name' => 'required|string|max:255|unique:headquarters,name,' . $headquarter->id . ',id,company_id,' . $request->company_id,
            'status_id' => 'required|exists:statuses,id',
        ]);

        try {

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
