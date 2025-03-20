<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileInformation extends Component
{
    public $user;

    public function mount()
    {
        // Obtén el usuario autenticado con las relaciones necesarias
        $this->user = Auth::user()->load(['status', 'company', 'headquarter.company']);
    }

    public function render()
    {
        return view('livewire.profile-information');
    }
}
