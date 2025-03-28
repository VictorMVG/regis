<?php

namespace App\Http\Controllers\Configuracion\Usuarios\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Usuarios\Catalogos\Company;
use App\Models\Configuracion\Catalogos\Status;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('configuracion.usuarios.catalogos.empresa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuracion.usuarios.catalogos.empresa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies',
            'alias' => 'required|string|max:255|unique:companies',
        ]);

        try {

            Company::create($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Empresa creada correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear la empresa.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('configuracion.usuarios.catalogos.empresa.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $statuses = Status::all();
        return view('configuracion.usuarios.catalogos.empresa.edit', compact('company', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id,
            'alias' => 'required|string|max:255|unique:companies,alias,' . $company->id,
            'status_id' => 'required|exists:statuses,id',
        ]);

        try {

            $company->update($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Empresa actualizada correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('companies.index');
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar la empresa.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try {

            $company->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Sede eliminada correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('companies.index');
        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar la sede.',
                'icon' => 'error',
            ]));
            
        }

        return redirect()->route('companies.index');
    }
}
