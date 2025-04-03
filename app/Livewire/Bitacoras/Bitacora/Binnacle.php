<?php

namespace App\Livewire\Bitacoras\Bitacora;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bitacoras\Bitacora\Binnacle as BinnacleWireModel;

class Binnacle extends Component
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
        $query = BinnacleWireModel::query()
            ->with(['observationType', 'user', 'headquarter.company']);

        // Ajusta la consulta según el rol del usuario
        if ($user->hasRole('SUPER USUARIO') || $user->hasRole('ADMINISTRADOR GENERAL')) {
            // No se aplica filtro adicional, muestra todas los registros de bitacora del día actual
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
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('observation', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('headquarter.company', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        });

        // Si el término de búsqueda es una fecha válida, filtra por fecha
        if (strtotime($this->search)) {
            $query->orWhereDate('created_at', $this->search);
        }

        $binnacles = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.bitacoras.bitacora.binnacle', compact('binnacles'));
    }
}
