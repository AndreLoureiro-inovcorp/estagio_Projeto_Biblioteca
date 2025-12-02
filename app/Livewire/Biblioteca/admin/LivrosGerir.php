<?php

namespace App\Livewire\Biblioteca\admin;

use Livewire\Component;
use App\Models\Livro;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class LivrosGerir extends Component
{
    use WithPagination;

    public $livroParaEliminar = null;

    public function eliminarDireto($livroId)
    {
        $livro = Livro::findOrFail($livroId);

        if ($livro->requisicoes()->where('estado', 'ativa')->exists()) {
            session()->flash('error', 'Não é possível eliminar este livro porque tem requisições ativas.');
            return;
        }

        $livro->delete();
        session()->flash('message', 'Livro eliminado com sucesso!');
    }

    public function render()
    {
        $livros = Livro::with(['autores', 'editora'])->latest()->paginate(6);

        return view('livewire.biblioteca.admin.livros-gerir', [
            'livros' => $livros,
        ]);
    }
}
