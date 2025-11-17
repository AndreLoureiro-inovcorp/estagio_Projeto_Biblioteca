<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class GerirUtilizadores extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::with('roles')->get();
    }

    public function tornarAdmin($userId)
    {
        $user = User::find($userId);
        
        // Remove role cidadao se tiver
        $user->removeRole('cidadao');
        
        // Adiciona role admin
        $user->assignRole('admin');
        
        session()->flash('message', 'Utilizador promovido a Admin!');
        
        // Recarrega lista
        $this->mount();
    }

    public function removerAdmin($userId)
    {
        $user = User::find($userId);
        
        // Remove role admin
        $user->removeRole('admin');
        
        // Adiciona role cidadao
        $user->assignRole('cidadao');
        
        session()->flash('message', 'Admin removido. Agora é Cidadão.');
        
        // Recarrega lista
        $this->mount();
    }

    public function render()
    {
        return view('livewire.admin.gerir-utilizadores');
    }
}
