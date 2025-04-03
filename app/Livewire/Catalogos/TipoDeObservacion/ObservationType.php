<?php

namespace App\Livewire\Catalogos\TipoDeObservacion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Catalogos\ObservationType as ObservationTypeWireModel;

class ObservationType extends Component
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
        $observationTypes = ObservationTypeWireModel::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.catalogos.tipo-de-observacion.observation-type', compact('observationTypes'));
    }
}
