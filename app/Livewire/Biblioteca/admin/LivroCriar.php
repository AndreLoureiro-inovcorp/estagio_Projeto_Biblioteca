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
class LivroCriar extends Component
{
    use WithFileUploads;

    public $isbn = '';

    public $nome = '';

    public $editora_id = '';

    public $autoresSelecionados = [];

    public $bibliografia = '';

    public $nova_imagem = null;

    public $preco = '';

    public $editoras = [];

    public $autores = [];

    public function mount()
    {
        $this->editoras = Editora::orderBy('nome')->get();
        $this->autores = Autor::orderBy('nome')->get();
    }

    protected function rules()
    {
        return [
            'isbn' => 'required|string|max:20|unique:livros,isbn',
            'nome' => 'required|string|max:255',
            'editora_id' => 'required|exists:editoras,id',
            'autoresSelecionados' => 'required|array|min:1',
            'autoresSelecionados.*' => 'exists:autores,id',
            'bibliografia' => 'nullable|string',
            'nova_imagem' => 'nullable|image|max:2048',
            'preco' => 'nullable|numeric|min:0',
        ];
    }

    protected $messages = [
        'isbn.required' => 'O ISBN é obrigatório.',
        'isbn.unique' => 'Este ISBN já está a ser usado por outro livro.',
        'nome.required' => 'O nome do livro é obrigatório.',
        'editora_id.required' => 'Tens de selecionar uma editora.',
        'editora_id.exists' => 'A editora selecionada não existe.',
        'autoresSelecionados.required' => 'Tens de selecionar pelo menos um autor.',
        'autoresSelecionados.min' => 'Tens de selecionar pelo menos um autor.',
        'nova_imagem.image' => 'O ficheiro tem de ser uma imagem.',
        'nova_imagem.max' => 'A imagem não pode ter mais de 2MB.',
        'preco.numeric' => 'O preço tem de ser um número.',
        'preco.min' => 'O preço não pode ser negativo.',
    ];

    public function guardar()
    {
        $this->validate();

        $dados = [
            'isbn' => $this->isbn,
            'nome' => $this->nome,
            'editora_id' => $this->editora_id,
            'bibliografia' => $this->bibliografia,
            'preco' => $this->preco,
            'disponivel' => true,
        ];

        if ($this->nova_imagem) {
            $dados['imagem_capa'] = $this->nova_imagem->store('livros', 'public');
        }

        $livro = Livro::create($dados);
        $livro->autores()->sync($this->autoresSelecionados);

        LogService::registar(
            'Livros',
            'Criou livro',
            "{$livro->nome} - ".$livro->autores->pluck('nome')->join(', ')
        );

        session()->flash('message', 'Livro criado com sucesso!');

        return redirect()->route('admin.livros');
    }

    public function render()
    {
        return view('livewire.biblioteca.admin.livro-criar');
    }
}
