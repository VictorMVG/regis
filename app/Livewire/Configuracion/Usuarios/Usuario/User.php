<?php

namespace App\Livewire\Configuracion\Usuarios\Usuario;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as UserWireModel;

class User extends Component
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
        $users = UserWireModel::with(['company', 'status', 'headquarter'])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhereHas('company', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('headquarter', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'SUPER USUARIO');
            })
            ->orderBy('status_id')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.configuracion.usuarios.usuario.user', compact('users'));
    }
}
