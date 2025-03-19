<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\UnitColor;
use Illuminate\Http\Request;


class UnitColorController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('catalogos.color-de-unidad.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('catalogos.color-de-unidad.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:unit_colors,name',
        ]);

        try {
            UnitColor::create($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Color de unidad creado correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('unit-colors.index');

        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear el color de unidad.',
                'icon' => 'error',
            ]));

        }

        return redirect()->route('unit-colors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitColor $unitColor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitColor $unitColor)
    {
        return view('catalogos.color-de-unidad.edit', compact('unitColor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitColor $unitColor)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:unit_colors,name,' . $unitColor->id,
        ]);

        try {
            $unitColor->update($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Color de unidad actualizado correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('unit-colors.index');

        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar el color de unidad.',
                'icon' => 'error',
            ]));

        }

        return redirect()->route('unit-colors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitColor $unitColor)
    {
        try {
            $unitColor->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Color de unidad eliminado correctamente',
                'icon' => 'success',
            ]));

        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar el color de unidad.',
                'icon' => 'error',
            ]));

        }

        return redirect()->route('unit-colors.index');
    }
}
