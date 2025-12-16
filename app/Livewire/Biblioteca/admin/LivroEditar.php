<?php

namespace App\Livewire\Biblioteca\admin;

use App\Models\Autor;
use App\Models\Editora;
use App\Models\Livro;
use App\Services\LogService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class LivroEditar extends Component
{
    use WithFileUploads;

    public $livroId;

    public $isbn;

    public $nome;

    public $editora_id;

    public $autoresSelecionados = [];

    public $bibliografia;

    public $nova_imagem;

    public $imagem_capa;

    public $preco;

    public $editoras = [];

    public $autores = [];

    public function mount($livro)
    {
        $livro = Livro::with('autores')->findOrFail($livro);

        $this->livroId = $livro->id;
        $this->isbn = $livro->isbn;
        $this->nome = $livro->nome;
        $this->editora_id = $livro->editora_id;
        $this->autoresSelecionados = $livro->autores->pluck('id')->toArray();
        $this->bibliografia = $livro->bibliografia;
        $this->imagem_capa = $livro->imagem_capa;
        $this->preco = $livro->preco;

        $this->editoras = Editora::orderBy('nome')->get();
        $this->autores = Autor::orderBy('nome')->get();
    }

    protected function rules()
    {
        return [
            'isbn' => 'required|string|max:20|unique:livros,isbn,'.$this->livroId,
            'nome' => 'required|string|max:255',
            'editora_id' => 'required|exists:editoras,id',
            'autoresSelecionados' => 'required|array|min:1',
            'autoresSelecionados.*' => 'exists:autores,id',
            'bibliografia' => 'nullable|string',
            'nova_imagem' => 'nullable|image|max:2048',
            'preco' => 'nullable|numeric|min:0',
        ];
    }

    public function atualizar()
    {
        $this->validate();

        $livro = Livro::findOrFail($this->livroId);

        $livro->isbn = $this->isbn;
        $livro->nome = $this->nome;
        $livro->editora_id = $this->editora_id;
        $livro->bibliografia = $this->bibliografia;
        $livro->preco = $this->preco;

        if ($this->nova_imagem) {
            $livro->imagem_capa = $this->nova_imagem->store('livros', 'public');
        }

        $livro->save();
        $livro->autores()->sync($this->autoresSelecionados);

        LogService::registar(
            'Livros',
            'Editou livro',
            "#{$livro->id} - {$livro->nome}"
        );

        session()->flash('message', 'Livro atualizado com sucesso!');

        return redirect()->route('admin.livros');
    }

    public function render()
    {
        return view('livewire.biblioteca.admin.livro-editar');
    }
}
