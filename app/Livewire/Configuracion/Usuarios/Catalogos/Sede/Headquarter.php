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
        $headquarters = HeadquarterWireModel::query()
            ->with('company', 'status')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('company', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.configuracion.usuarios.catalogos.sede.headquarter', compact('headquarters'));
    }
}
