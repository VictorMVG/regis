<?php

namespace App\Http\Controllers\Configuracion\Usuarios\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Usuarios\Catalogos\Company;
use App\Models\Configuracion\Catalogos\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'headquarter' => 'required|string|max:255',
            'company' => 'required|string|max:255',
        ]);
    
        // Verificar la combinación única de headquarter y company
        $exists = Company::where('headquarter', $request->headquarter)
                         ->where('company', $request->company)
                         ->exists();
    
        if ($exists) {
            return redirect()->back()->withErrors(['headquarter' => 'La combinación de Empresa y Sede ya existe.'])->withInput();
        }
    
        try {
            $data = $request->only(['headquarter', 'company']);
            $data['status_id'] = 1; // Establecer el valor predeterminado de status_id
    
            Company::create($data);
    
            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Sede creada correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear la sede.',
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
            'headquarter' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'status_id' => 'required|exists:statuses,id',
        ]);
    
        // Verificar la combinación única de headquarter y company
        $exists = Company::where('headquarter', $request->headquarter)
                         ->where('company', $request->company)
                         ->where('id', '!=', $company->id)
                         ->exists();
    
        if ($exists) {
            return redirect()->back()->withErrors(['headquarter' => 'La combinación de Empresa y Sede ya existe.'])->withInput();
        }
    
        try {
            $data = $request->only(['headquarter', 'company', 'status_id']);
    
            $company->update($data);
    
            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Sede actualizada correctamente',
                'icon' => 'success',
            ]));
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar la sede.',
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
