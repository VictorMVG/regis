<?php

namespace App\Livewire\Catalogos\TipoDeUnidad;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Catalogos\UnitType as UnitTypeWireModel;

class UnitType extends Component
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
        $unitTypes = UnitTypeWireModel::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.catalogos.tipo-de-unidad.unit-type', compact('unitTypes'));
    }
}
