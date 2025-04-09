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
        $user = Auth::user();
    
        $query = BinnacleWireModel::query()
            ->with(['user', 'headquarter', 'observationType', 'updatedBy']);
    
        // Filtro por rol
        if ($user->hasRole('SUPER USUARIO') || $user->hasRole('ADMINISTRADOR GENERAL')) {
            // Sin filtros adicionales
        } elseif ($user->hasRole('ADMINISTRADOR DE SEDE')) {
            $query->whereHas('headquarter.company', function ($q) use ($user) {
                $q->where('id', $user->company_id);
            });
        } elseif ($user->hasRole('GUARDIA')) {
            $query->where('headquarter_id', $user->headquarter_id);
        } else {
            $query->whereRaw('1 = 0');
        }
    
        // Búsqueda general
        $query->where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('observation', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('headquarter', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('company', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                })
                ->orWhereHas('observationType', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
    
            // Si el término de búsqueda es una fecha válida
            // if (strtotime($this->search)) {
            //     $query->orWhereDate('created_at', $this->search);
            // }
        });
    
        $binnacles = $query->orderBy('id', 'desc')->paginate(10);
    
        return view('livewire.bitacoras.bitacora.binnacle', compact('binnacles'));
    }
}
