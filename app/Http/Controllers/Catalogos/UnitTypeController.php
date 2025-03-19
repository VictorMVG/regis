<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\UnitType;
use Illuminate\Http\Request;

class UnitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('catalogos.tipo-de-unidad.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('catalogos.tipo-de-unidad.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:unit_types,name',
        ]);

        try {
            UnitType::create($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Tipo de unidad creado correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('unit-types.index');

        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear el tipo de unidad.',
                'icon' => 'error',
            ]));

        }

        return redirect()->route('unit-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitType $unitType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitType $unitType)
    {
        return view('catalogos.tipo-de-unidad.edit', compact('unitType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitType $unitType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:unit_types,name,' . $unitType->id,
        ]);

        try {
            $unitType->update($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Tipo de unidad actualizado correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('unit-types.index');

        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar el tipo de unidad.',
                'icon' => 'error',
            ]));

        }

        return redirect()->route('unit-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitType $unitType)
    {
        try {
            $unitType->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Tipo de unidad eliminado correctamente',
                'icon' => 'success',
            ]));

        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar el tipo de unidad.',
                'icon' => 'error',
            ]));

        }

        return redirect()->route('unit-types.index');
    }
}
