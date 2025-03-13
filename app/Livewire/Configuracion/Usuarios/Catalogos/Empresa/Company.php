<?php

namespace App\Livewire\Configuracion\Usuarios\Catalogos\Empresa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Configuracion\Usuarios\Catalogos\Company as CompanyWireModel;

class Company extends Component
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
        $companies = CompanyWireModel::query()
            ->where('company', 'like', '%' . $this->search . '%')
            ->orWhere('headquarter', 'like', '%' . $this->search . '%')
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.configuracion.usuarios.catalogos.empresa.company', compact('companies'));
    }
}
