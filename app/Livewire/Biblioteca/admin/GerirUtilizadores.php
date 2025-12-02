<?php

namespace App\Livewire\Biblioteca\admin;

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
        
        $user->removeRole('cidadao');
        
        $user->assignRole('admin');
        
        session()->flash('message', 'Utilizador promovido a Admin!');
        
        $this->mount();
    }

    public function removerAdmin($userId)
    {
        $user = User::find($userId);
        
        $user->removeRole('admin');
        
        $user->assignRole('cidadao');
        
        session()->flash('message', 'Admin removido. Agora é Cidadão.');
        
        $this->mount();
    }

    public function render()
    {
        return view('livewire.biblioteca.admin.gerir-utilizadores');
    }
}
