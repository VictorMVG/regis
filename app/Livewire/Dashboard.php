<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Visitas\Visita\Visit as VisitWireModel;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
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
            ->with(['unitColor', 'unitType', 'user', 'headquarter.company'])
            ->whereDate('created_at', $currentDate); // Filtra por la fecha actual

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
        });

        $visits = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.dashboard', compact('visits'));
    }
}
