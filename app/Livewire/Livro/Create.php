<?php

namespace App\Livewire\Livro;

use App\Models\Autor;
use App\Models\Editora;
use Livewire\Component;
use App\Models\Livro;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Create extends Component
{
    public $titulo;
    public $editora_id;
    public $autores = [];

    public function save()
    {
        $this->validate([
            'titulo' => 'required|string|max:255',
            'editora_id' => 'required|exists:editoras,id',
            'editores' => 'required|array|min:1',
            'editores.*' => 'exists:autores,id',
        ]);

        $livro = Livro::create([
            'titulo' => $this->titulo,
            'editora_id' => $this->editora_id,
        ]);

        $livro->autores()->attach($this->autores);

        session()->flash('message', 'Livro criado com sucesso!');
        return redirect()->route('livros.index');
    }
    public function render()
    {
        return view('livewire.livro.create', [
            'editoras' => Editora::all(),
            'autores' => Autor::all(),
        ]);
    }
}
