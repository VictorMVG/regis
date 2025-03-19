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
        // Usuario autenticado
        $authUser = auth()->user();

        // Construir la consulta base
        $usersQuery = UserWireModel::with(['company', 'status', 'headquarter'])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhereHas('company', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('headquarter', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            });

        // Aplicar filtros según el rol del usuario autenticado
        if ($authUser->hasRole('ADMINISTRADOR DE SEDE')) {
            // Filtrar usuarios por el company_id relacionado con visits->headquarter->company->id
            $usersQuery->whereHas('headquarter.company', function ($query) use ($authUser) {
                $query->where('id', $authUser->company_id);
            });
        } elseif (!$authUser->hasRole('SUPER USUARIO') && !$authUser->hasRole('ADMINISTRADOR GENERAL')) {
            // Si no es SUPER USUARIO ni ADMINISTRADOR GENERAL, excluir usuarios con el rol SUPER USUARIO
            $usersQuery->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'SUPER USUARIO');
            });
        }

        // Ordenar y paginar los resultados
        $users = $usersQuery
            ->orderBy('status_id')
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('livewire.configuracion.usuarios.usuario.user', compact('users'));
    }
}
