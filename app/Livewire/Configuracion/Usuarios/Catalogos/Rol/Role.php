<?php

namespace App\Livewire\Configuracion\Usuarios\Catalogos\Rol;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role as RoleWireModel;

class Role extends Component
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
        $roles = RoleWireModel::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.configuracion.usuarios.catalogos.rol.role', compact('roles'));
    }
}
