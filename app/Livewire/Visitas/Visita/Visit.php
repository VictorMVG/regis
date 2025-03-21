<?php

namespace App\Livewire\Visitas\Visita;

use App\Exports\VisitsFilteredExport;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Visitas\Visita\Visit as VisitWireModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class Visit extends Component
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
        // Obtén el usuario autenticado
        $user = Auth::user();

        // Obtén la fecha actual
        $currentDate = now()->toDateString();

        // Construye la consulta base
        $query = VisitWireModel::query()
            ->with(['unitColor', 'unitType', 'user', 'headquarter.company']);

        // Ajusta la consulta según el rol del usuario
        if ($user->hasRole('SUPER USUARIO') || $user->hasRole('ADMINISTRADOR GENERAL')) {
            // No se aplica filtro adicional, muestra todas las visitas del día actual
        } elseif ($user->hasRole('ADMINISTRADOR DE SEDE')) {
            // Filtra por el company_id relacionado con el usuario
            $query->whereHas('headquarter.company', function ($q) use ($user) {
                $q->where('id', $user->company_id);
            });
        } elseif ($user->hasRole('GUARDIA')) {
            // Filtra por el headquarter_id relacionado con el usuario
            $query->where('headquarter_id', $user->headquarter_id);
        } else {
            // Si el usuario no tiene ninguno de los roles especificados, devuelve una consulta vacía
            $query->whereRaw('1 = 0'); // Esto asegura que no se devuelvan registros
        }

        // Aplica búsqueda en múltiples campos
        $query->where(function ($query) {
            $query->where('visitor_name', 'like', '%' . $this->search . '%')
                ->orWhere('company_name', 'like', '%' . $this->search . '%')
                ->orWhere('unit_plate', 'like', '%' . $this->search . '%')
                ->orWhere('unit_model', 'like', '%' . $this->search . '%')
                ->orWhere('unit_number', 'like', '%' . $this->search . '%')
                ->orWhereHas('unitColor', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('unitType', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('headquarter', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('company', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });

            // Si el término de búsqueda es una fecha válida, filtra por fecha
            if (strtotime($this->search)) {
                $query->orWhereDate('created_at', $this->search);
            }
        });

        $visits = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.visitas.visita.visit', compact('visits'));
    }

    public function export()
    {
        // Obtén el usuario autenticado
        $user = Auth::user();

        // Construye la consulta base
        $query = VisitWireModel::query()
            ->with(['unitColor', 'unitType', 'user', 'headquarter.company']);

        // Ajusta la consulta según el rol del usuario
        if ($user->hasRole('SUPER USUARIO') || $user->hasRole('ADMINISTRADOR GENERAL')) {
            // No se aplica filtro adicional, muestra todas las visitas
        } elseif ($user->hasRole('ADMINISTRADOR DE SEDE')) {
            // Filtra por el company_id relacionado con el usuario
            $query->whereHas('headquarter.company', function ($q) use ($user) {
                $q->where('id', $user->company_id);
            });
        } elseif ($user->hasRole('GUARDIA')) {
            // Filtra por el headquarter_id relacionado con el usuario
            $query->where('headquarter_id', $user->headquarter_id);
        } else {
            // Si el usuario no tiene ninguno de los roles especificados, devuelve una consulta vacía
            $query->whereRaw('1 = 0'); // Esto asegura que no se devuelvan registros
        }

        // Aplica búsqueda en múltiples campos
        if ($this->search) {
            $query->where(function ($query) {
                $query->where('visitor_name', 'like', '%' . $this->search . '%')
                    ->orWhere('company_name', 'like', '%' . $this->search . '%')
                    ->orWhere('unit_plate', 'like', '%' . $this->search . '%')
                    ->orWhere('unit_model', 'like', '%' . $this->search . '%')
                    ->orWhere('unit_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('unitColor', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('unitType', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('headquarter', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhereHas('company', function ($q) {
                                $q->where('name', 'like', '%' . $this->search . '%');
                            });
                    });

                // Si el término de búsqueda es una fecha válida, filtra por fecha
                if (strtotime($this->search)) {
                    $query->orWhereDate('created_at', $this->search);
                }
            });
        }

        // Pasa la consulta completa a la clase de exportación
        return Excel::download(new VisitsFilteredExport($query), 'visitas_filtradas.xlsx');
    }
}
