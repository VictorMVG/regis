<?php

namespace App\Http\Controllers\Visitas\Visita;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\UnitColor;
use App\Models\Catalogos\UnitType;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use App\Models\Visitas\Visita\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('visitas.visita.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unitColors = UnitColor::all();
        $unitTypes = UnitType::all();
        $headquarters = Headquarter::with('company')->get();
        return view('visitas.visita.create', compact('unitColors', 'unitTypes', 'headquarters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //usuario autenticado
        $user = Auth::user();

        //validar que el usuario autenticado tenga una sede asignada
        if (!$user->headquarter_id) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'No tienes una sede asignada, por favor contacta al administrador para que te la asignen.',
                'icon' => 'error',
            ]));

            return redirect()->route('visits.create');
        }

        $data = $request->all();

        // Convertir los valores de "on" a booleanos
        $data['alcohol_test'] = $request->has('alcohol_test') && $request->alcohol_test === 'on' ? true : false;
        $data['unit'] = $request->has('unit') && $request->unit === '1' ? true : false;

        $validated = Validator::make($data, [
            'headquarter_id' => 'nullable|exists:headquarters,id',
            'visitor_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'to_see' => 'required|string|max:255',
            'alcohol_test' => 'required|boolean',
            'unit' => 'required|boolean',
            'unit_plate' => 'nullable|string|max:255',
            'unit_model' => 'nullable|string|max:255',
            'unit_number' => 'nullable|string|max:255',
            'unit_type_id' => 'nullable|exists:unit_types,id',
            'unit_color_id' => 'nullable|exists:unit_colors,id',
            'comment' => 'nullable|string',
        ])->validate();

        $validated['user_id'] = Auth::id();
        $validated['headquarter_id'] = $user->hasRole('GUARDIA') ? $user->headquarter_id : $validated['headquarter_id'];
        $validated['exit_time'] = null;

        try {
            Visit::create($validated);

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Visita creada correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear la visita.' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visit $visit)
    {
        $unitColors = UnitColor::all();
        $unitTypes = UnitType::all();
        $headquarters = Headquarter::with('company')->get();
        return view('visitas.visita.edit', compact('visit', 'unitColors', 'unitTypes', 'headquarters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        //
    }

    /**
     * Update the exit_time for a specific visit.
     */
    public function updateExitTime(Request $request, Visit $visit)
    {
        try {

            //usuario autenticado
            $user = Auth::user();

            $visit->update([
                'exit_time' => now(),
                'exit_registered_by' => $user->id,
            ]);

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Hora de salida registrada correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al registrar la hora de salida.',
                'icon' => 'error',
            ]));
        }

        return redirect()->route('dashboard');
    }
}
