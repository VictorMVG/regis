<?php

namespace App\Livewire\Configuracion\Usuarios\Catalogos\Sede;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Configuracion\Usuarios\Catalogos\Headquarter as HeadquarterWireModel;

class Headquarter extends Component
{
    use WithPagination;

    public $search = '';
    public $page = 1;

    protected $queryString = ['search', 'page'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Usuario autenticado
        $authUser = auth()->user();

        // Construir la consulta base
        $headquartersQuery = HeadquarterWireModel::query()
            ->with('company', 'status')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('company', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            });

        // Aplicar filtros según el rol del usuario autenticado
        if ($authUser->hasRole('ADMINISTRADOR DE SEDE')) {
            // Filtrar por el company_id del usuario autenticado
            $headquartersQuery->where('company_id', $authUser->company_id);
        }

        // Ordenar y paginar los resultados
        $headquarters = $headquartersQuery
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.configuracion.usuarios.catalogos.sede.headquarter', compact('headquarters'));
    }
}
