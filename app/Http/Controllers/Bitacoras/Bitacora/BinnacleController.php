<?php

namespace App\Http\Controllers\Bitacoras\Bitacora;

use App\Exports\BinnacleFilteredExport;
use App\Exports\BinnaclesTodayExport;
use App\Http\Controllers\Controller;
use App\Models\Bitacoras\Bitacora\Binnacle;
use App\Models\Catalogos\ObservationType;
use App\Models\Configuracion\Catalogos\Status;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BinnacleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bitacoras.bitacora.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        $observationTypes = ObservationType::all();

        if ($user->hasRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL'])) {
            $headquarters = Headquarter::with('company')->get();
        } else {
            $headquarters = Headquarter::where('company_id', $user->company_id)->with('company')->get();
        }

        return view('bitacoras.bitacora.create', compact('observationTypes', 'headquarters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Usuario autenticado
        $user = Auth::user();

        $data = $request->all();

        // Validar los datos
        $validated = Validator::make($data, [
            'headquarter_id' => 'exists:headquarters,id',
            'observation_type_id' => 'required|exists:observation_types,id',
            'title' => 'required|string|max:255',
            'observation' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validar cada imagen
        ])->validate();

        // Asignar el usuario autenticado
        $validated['user_id'] = $user->id;

        // SI EL HEADQUARTER_ID ESTA VACIO, SE ASIGNA EL HEADQUARTER DEL USUARIO
        if (empty($validated['headquarter_id'])) {
            $validated['headquarter_id'] = $user->headquarter_id;
        } elseif ($user->hasRole('ADMINISTRADOR DE SEDE')) {
            // Validar que el headquarter_id sea del mismo company_id que el usuario si es ADMINISTRADOR DE SEDE
            $headquarter = Headquarter::find($validated['headquarter_id']);
            if ($headquarter && $headquarter->company_id !== $user->company_id) {
                session()->flash('swal', json_encode([
                    'title' => 'Error',
                    'text' => 'La sede seleccionada no pertenece a tu empresa asignada. Comunícate con tu administrador general si crees que es un error.',
                    'icon' => 'error',
                ]));

                return redirect()->route('binnacles.create')->withInput();
            }
        } else {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Ocurrió un error inesperado. Comunícate con tu administrador general.',
                'icon' => 'error',
            ]));
        }

        // Manejar las imágenes
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('binnacles/images', 'public'); // Guardar en el disco 'public'
                $images[] = $path;
            }
        }
        $validated['images'] = $images;

        try {
            // Validar que el headquarter_id esté ACTIVO (A)
            $headquarter = Headquarter::find($validated['headquarter_id']);

            if (!$headquarter || $headquarter->status_id !== Status::where('name', 'ACTIVO (A)')->value('id')) {
                session()->flash('swal', json_encode([
                    'title' => 'Error',
                    'text' => 'No puedes crear bitácoras para una sede inactiva. Contacta con tu administrador de sedes para que la active de nuevo.',
                    'icon' => 'error',
                ]));

                return redirect()->route('binnacles.create')->withInput();
            }

            // Crear la bitácora
            Binnacle::create($validated);

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Registro de bitácora creada correctamente',
                'icon' => 'success',
            ]));

            // si el usuario es GUARDIA se redirige al dashboard
            if ($user->hasRole('GUARDIA')) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('binnacles.index');
            }
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al crear el registro de bitácora. ' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Binnacle $binnacle)
    {
        return view('bitacoras.bitacora.show', compact('binnacle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Binnacle $binnacle)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        //SI EL ROL DEL USUARIO AUTENTICADO ES GUARDIA, NO DEBERIA PODER ACCEDER A EDITAR REGISTROS QUE NO LE PERTENECEN MOSTRANDO UN 404 PAGINA NO ENCONTRADA
        if ($user->hasRole('GUARDIA') && $binnacle->user_id !== $user->id) {
            abort(404);
        } elseif ($user->hasRole('ADMINISTRADOR DE SEDE') && $binnacle->headquarter->company->id !== $user->company_id) {
            abort(404);
        }

        $observationTypes = ObservationType::all();

        if ($user->hasRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL'])) {
            $headquarters = Headquarter::with('company')->get();
        } else {
            $headquarters = Headquarter::where('company_id', $user->company_id)->with('company')->get();
        }

        return view('bitacoras.bitacora.edit', compact('binnacle', 'observationTypes', 'headquarters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Binnacle $binnacle)
    {
        // Usuario autenticado
        $user = Auth::user();

        $data = $request->all();

        // Validar los datos
        $validated = Validator::make($data, [
            'headquarter_id' => 'exists:headquarters,id',
            'observation_type_id' => 'required|exists:observation_types,id',
            'title' => 'required|string|max:255',
            'observation' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validar cada imagen
            'created_at' => 'nullable|date', // Validar que sea una fecha válida
        ])->validate();

        // Asignar el usuario autenticado
        $validated['user_id'] = $user->id;

        // Validar el headquarter_id para el rol ADMINISTRADOR DE SEDE
        if ($user->hasRole('ADMINISTRADOR DE SEDE')) {
            $headquarter = Headquarter::find($validated['headquarter_id']);
            if ($headquarter && $headquarter->company_id !== $user->company_id) {
                session()->flash('swal', json_encode([
                    'title' => 'Error',
                    'text' => 'La sede seleccionada no pertenece a tu empresa asignada. Comunícate con tu administrador general si crees que es un error.',
                    'icon' => 'error',
                ]));

                return redirect()->route('binnacles.edit', $binnacle->id)->withInput();
            }
        }

        // Verificar si el toggle "image" está desactivado
        if (!$request->input('image')) {
            // Eliminar todas las imágenes del sistema
            foreach ($binnacle->images ?? [] as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }

            // Limpiar el campo "images"
            $validated['images'] = [];
        } else {
            // Manejar las imágenes existentes
            $existingImages = $binnacle->images ?? [];
            $newImages = [];
            $imagesToKeep = $request->input('existing_images', []); // Imágenes que el usuario desea mantener

            // Eliminar las imágenes que no se desean mantener
            foreach ($existingImages as $image) {
                if (!in_array($image, $imagesToKeep)) {
                    // Eliminar la imagen del sistema
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                } else {
                    // Mantener la imagen
                    $newImages[] = $image;
                }
            }

            // Manejar las nuevas imágenes subidas
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('binnacles/images', 'public'); // Guardar en el disco 'public'
                    $newImages[] = $path;
                }
            }

            $validated['images'] = $newImages;
        }

        try {
            // Validar que el headquarter_id esté ACTIVO (A)
            $headquarter = Headquarter::find($validated['headquarter_id']);

            if (!$headquarter || $headquarter->status_id !== Status::where('name', 'ACTIVO (A)')->value('id')) {
                session()->flash('swal', json_encode([
                    'title' => 'Error',
                    'text' => 'No puedes actualizar bitácoras para una sede inactiva. Contacta con tu administrador de sedes para que la active de nuevo.',
                    'icon' => 'error',
                ]));

                return redirect()->route('binnacles.edit', $binnacle->id)->withInput();
            }

            $binnacle->update(array_merge($validated, [
                'created_at' => $validated['created_at'] ?? $binnacle->created_at, // Mantener el valor actual si no se envía
            ]));

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Registro de bitácora actualizado correctamente',
                'icon' => 'success',
            ]));

            // si el usuario es GUARDIA se redirige al dashboard
            if ($user->hasRole('GUARDIA')) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('binnacles.index');
            }
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar el registro de bitácora. ' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->route('binnacles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Binnacle $binnacle)
    {
        try {
            // Eliminar las imágenes del sistema
            foreach ($binnacle->images ?? [] as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }

            // Eliminar la bitácora
            $binnacle->delete();

            session()->flash('swal', json_encode([
                'title' => '!Bien hecho!',
                'text' => 'Registro de bitácora eliminado correctamente',
                'icon' => 'success',
            ]));

            return redirect()->route('binnacles.index');
        } catch (\Exception $e) {
            session()->flash('swal', json_encode([
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar el registro de bitácora. ' . $e->getMessage(),
                'icon' => 'error',
            ]));
        }

        return redirect()->route('binnacles.index');
    }

    public function export()
    {
        $user = Auth::user(); // Usuario autenticado
        $timestamp = now()->format('d-m-Y_H-i'); // Fecha y hora actual en formato dd-mm-aaaa_hh-mm
        $fileName = '';

        // Construir el nombre del archivo según el rol
        if ($user->hasRole(['SUPER USUARIO', 'ADMINISTRADOR GENERAL'])) {
            $fileName = "bitacoras_diarias_de_todas_las_sedes_{$timestamp}.xlsx";
        } elseif ($user->hasRole('ADMINISTRADOR DE SEDE')) {
            $companyName = $user->company->name; // Relación con la compañía
            $fileName = "bitacoras_diarias_de_{$companyName}_todas_las_sedes_{$timestamp}.xlsx";
        } elseif ($user->hasRole('GUARDIA')) {
            $headquarterName = $user->headquarter->name; // Relación con la sede
            $fileName = "bitacoras_diarias_de_la_sede_{$headquarterName}_{$timestamp}.xlsx";
        } else {
            $fileName = "bitacoras_diarias_{$timestamp}.xlsx"; // Nombre genérico para otros roles
        }

        return Excel::download(new BinnaclesTodayExport, $fileName);
    }
}
