<?php

namespace App\Http\Controllers\Visitas\Visita;

use App\Exports\VisitsExport;
use App\Exports\VisitsFilteredExport;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\UnitColor;
use App\Models\Catalogos\UnitType;
use App\Models\Configuracion\Catalogos\Status;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use App\Models\Visitas\Visita\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
        // Usuario autenticado
        $user = Auth::user();

        $unitColors = UnitColor::all();
        $unitTypes = UnitType::all();

        if ($user->hasRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL'])) {
            $headquarters = Headquarter::with('company')->get();
        } else {
            $headquarters = Headquarter::where('company_id', $user->company_id)->with('company')->get();
        }

        return view('visitas.visita.create', compact('unitColors', 'unitTypes', 'headquarters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //usuario autenticado
        $user = Auth::user();

        $data = $request->all();

        // Convertir los valores de los toggles a booleanos
        $data['alcohol_test'] = filter_var($request->input('alcohol_test'), FILTER_VALIDATE_BOOLEAN);
        $data['unit'] = filter_var($request->input('unit'), FILTER_VALIDATE_BOOLEAN);

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

        // Si el toggle "unit" es falso, limpiar los campos relacionados con el vehículo
        if (!$validated['unit']) {
            $validated['unit_plate'] = null;
            $validated['unit_model'] = null;
            $validated['unit_number'] = null;
            $validated['unit_type_id'] = null;
            $validated['unit_color_id'] = null;
        }

        try {

            // Validar que el headquarter_id esté ACTIVO (A)
            $headquarter = Headquarter::find($validated['headquarter_id']);

            if (!$headquarter || $headquarter->status_id !== Status::where('name', 'ACTIVO (A)')->value('id')) {
                session()->flash('swal', json_encode([
                    'title' => 'Error',
                    'text' => 'No puedes crear visitas para una sede inactiva. Contacta con tu administrador de sedes para que la active de nuevo.',
                    'icon' => 'error',
                ]));

                return redirect()->route('visits.create')->withInput();
            }

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
        // Usuario autenticado
        $user = Auth::user();

        // Si el usuario es ADMINISTRADOR DE SEDE y no coincide el company_id, lanzar error 404
        if ($user->hasRole('ADMINISTRADOR DE SEDE') && $user->company_id !== $visit->headquarter->company_id) {
            abort(404); // Mostrar página de error 404
        }

        $unitColors = UnitColor::all();
        $unitTypes = UnitType::all();

        if ($user->hasRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL'])) {
            $headquarters = Headquarter::with('company')->get();
        } else {
            $headquarters = Headquarter::where('company_id', $user->company_id)->with('company')->get();
        }

        return view('visitas.visita.edit', compact('visit', 'unitColors', 'unitTypes', 'headquarters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit)
    {
        // Usuario autenticado
        $user = Auth::user();

        $data = $request->all();

        // Convertir los valores de los toggles a booleanos
        $data['alcohol_test'] = filter_var($request->input('alcohol_test'), FILTER_VALIDATE_BOOLEAN);
        $data['unit'] = filter_var($request->input('unit'), FILTER_VALIDATE_BOOLEAN);

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
            'created_at' => 'nullable|date', // Validar que sea una fecha válida
            'exit_time' => 'nullable|date', // Validar que sea una fecha válida
        ])->validate();

        $validated['headquarter_id'] = $user->hasRole('GUARDIA')
            ? $user->headquarter_id
            : ($validated['headquarter_id'] ?? $visit->headquarter_id);

        // Si el toggle "unit" es falso, limpiar los campos relacionados con el vehículo
        if (!$validated['unit']) {
            $validated['unit_plate'] = null;
            $validated['unit_model'] = null;
            $validated['unit_number'] = null;
            $validated['unit_type_id'] = null;
            $validated['unit_color_id'] = null;
        }

        try {
            // Validar que el headquarter_id esté ACTIVO (A)
            $headquarter = Headquarter::find($validated['headquarter_id']);

            if (!$headquarter || $headquarter->status_id !== Status::where('name', 'ACTIVO (A)')->value('id')) {
                session()->flash('swal', json_encode([
                    'title' => 'Error',
                    'text' => 'No puedes actualizar visitas para una sede inactiva. Contacta con tu administrador de sedes para que la active de nuevo.',
                    'icon' => 'error',
                ]));

                return redirect()->route('visits.edit', $visit->id);
            }

            // si tu rol es diferente de SUPER USUARIO Y ADMINISTRADOR GENERAL solo debe permitirte editar el registro que coincida con el company_id
            if ($user->hasRole(['GUARDIA', 'ADMINISTRADOR DE SEDE'])) {
                if ($user->company_id !== $visit->headquarter->company_id) {
                    session()->flash('swal', json_encode([
                        'title' => 'Error',
                        'text' => 'No tienes permiso para editar esta visita.',
                        'icon' => 'error',
                    ]));

                    return redirect()->route('visits.edit', $visit->id);
                }
            }

            // Actualizar el registro
            $visit->update(array_merge($validated, [
                'created_at' => $validated['created_at'] ?? $visit->created_at, // Mantener el valor actual si no se envía
                'exit_time' => $validated['exit_time'] ?? $visit->exit_time,   // Mantener el valor actual si no se envía
            ]));

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Visita actualizada correctamente',
                'icon' => 'success',
            ]));

            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar la visita. ' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        try {
            $visit->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Visita eliminada correctamente',
                'icon' => 'success',
            ]));

            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar la visita. ' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->back();
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

    public function export()
    {
        $user = Auth::user(); // Usuario autenticado
        $timestamp = now()->format('d-m-Y_H-i'); // Fecha y hora actual en formato dd-mm-aaaa_hh-mm
        $fileName = '';

        // Construir el nombre del archivo según el rol
        if ($user->hasRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL'])) {
            $fileName = "visitas_diarias_de_todas_las_sedes_{$timestamp}.xlsx";
        } elseif ($user->hasRole('ADMINISTRADOR DE SEDE')) {
            $companyName = $user->company->name; // Relación con la compañía
            $fileName = "visitas_diarias_de_{$companyName}_todas_las_sedes_{$timestamp}.xlsx";
        } else {
            $fileName = "visitas_diarias_{$timestamp}.xlsx"; // Nombre genérico para otros roles
        }

        return Excel::download(new VisitsExport, $fileName);
    }

    public function exportFiltered(Request $request)
    {
        $search = $request->input('search'); // Obtener el filtro de búsqueda

        // Pasar los filtros a la clase de exportación
        return Excel::download(new VisitsFilteredExport($search), 'visitas_filtradas.xlsx');
    }
}
