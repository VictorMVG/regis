<?php

namespace App\Livewire\Catalogos\ColorDeUnidad;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Catalogos\UnitColor as UnitColorWireModel;

class UnitColor extends Component
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
        $unitColors = UnitColorWireModel::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.catalogos.color-de-unidad.unit-color', compact('unitColors'));
    }
}
