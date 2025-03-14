<?php

namespace App\Livewire\Configuracion\Usuarios\Catalogos\Permiso;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission as PermissionWireModel;

class Permission extends Component
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
        $permissions = PermissionWireModel::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.configuracion.usuarios.catalogos.permiso.permission', compact('permissions'));
    }
}
