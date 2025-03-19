<?php

namespace App\Http\Controllers\Visitas\Visita;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\UnitColor;
use App\Models\Catalogos\UnitType;
use App\Models\Visitas\Visita\Visit;
use Illuminate\Http\Request;

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
        return view('visitas.visita.create', compact('unitColors', 'unitTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return view('visitas.visita.edit', compact('visit', 'unitColors', 'unitTypes'));
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
}
