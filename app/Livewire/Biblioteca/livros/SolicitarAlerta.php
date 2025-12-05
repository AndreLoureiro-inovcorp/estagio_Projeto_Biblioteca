<?php

namespace App\Livewire\Biblioteca\livros;

use App\Models\AlertaLivro;
use App\Models\Livro;
use Livewire\Component;

class SolicitarAlerta extends Component
{
    public $livroId;

    public $jaPediu = false;

    public function mount($livroId)
    {
        $this->livroId = $livroId;

        if (auth()->check()) {
            $this->jaPediu = AlertaLivro::where('user_id', auth()->id())
                ->where('livro_id', $this->livroId)
                ->where('notificado', false)
                ->exists();
        }
    }

    public function solicitarAlerta()
    {

        $alertaExistente = AlertaLivro::where('user_id', auth()->id())
            ->where('livro_id', $this->livroId)
            ->where('notificado', false)
            ->first();

        AlertaLivro::create([
            'user_id' => auth()->id(),
            'livro_id' => $this->livroId,
            'notificado' => false,
        ]);

        $this->jaPediu = true;
    }

    public function render()
    {
        $livro = Livro::findOrFail($this->livroId);

        return view('livewire.biblioteca.livros.solicitar-alerta', [
            'livro' => $livro,
        ]);
    }
}
