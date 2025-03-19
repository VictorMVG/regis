<?php

namespace App\Livewire\Visitas\Visita;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Visitas\Visita\Visit as VisitWireModel;

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
        $visits = VisitWireModel::query()
            ->with(['unitColor', 'unitType', 'user'])
            ->where(function ($query) {
                $query->where('visitor_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.visitas.visita.visit', compact('visits'));
    }
}
