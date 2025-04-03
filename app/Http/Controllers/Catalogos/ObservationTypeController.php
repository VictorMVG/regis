<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\ObservationType;
use Illuminate\Http\Request;

class ObservationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('catalogos.tipo-de-observacion.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('catalogos.tipo-de-observacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:observation_types,name',
        ]);

        try {
            ObservationType::create($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Tipo de observación creado correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('observation-types.index');

        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear el tipo de observación.',
                'icon' => 'error',
            ]));

        }

        return redirect()->route('observation-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ObservationType $observationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ObservationType $observationType)
    {
        return view('catalogos.tipo-de-observacion.edit', compact('observationType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ObservationType $observationType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:observation_types,name,' . $observationType->id,
        ]);

        try {
            $observationType->update($request->all());

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Tipo de observación actualizado correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('observation-types.index');

        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar el tipo de observación.',
                'icon' => 'error',
            ]));

        }

        return redirect()->route('observation-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ObservationType $observationType)
    {
        try {
            $observationType->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Tipo de observación eliminado correctamente',
                'icon' => 'success',
            ]));

        } catch (\Exception $e) {

            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar el tipo de observación.',
                'icon' => 'error',
            ]));

        }

        return redirect()->route('observation-types.index');
    }
}
