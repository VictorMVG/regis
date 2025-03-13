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
        $users = UserWireModel::with(['company'])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhereHas('company', function ($query) {
                        $query->where('company', 'like', '%' . $this->search . '%')
                            ->orWhere('headquarter', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.configuracion.usuarios.usuario.user', compact('users'));
    }
}
