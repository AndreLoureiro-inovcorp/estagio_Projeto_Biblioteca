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

        // Verificar se o user já pediu alerta para este livro
        if (auth()->check()) {
            $this->jaPediu = AlertaLivro::where('user_id', auth()->id())
                ->where('livro_id', $this->livroId)
                ->where('notificado', false)
                ->exists();
        }
    }

    public function solicitarAlerta()
    {

        // Verificar se já pediu alerta
        $alertaExistente = AlertaLivro::where('user_id', auth()->id())
            ->where('livro_id', $this->livroId)
            ->where('notificado', false)
            ->first();

        if ($alertaExistente) {
            session()->flash('info', 'Já pediste notificação para este livro!');

            return;
        }

        // Criar novo alerta
        AlertaLivro::create([
            'user_id' => auth()->id(),
            'livro_id' => $this->livroId,
            'notificado' => false,
        ]);

        $this->jaPediu = true;

        session()->flash('success', 'Vais receber um email quando este livro ficar disponível!');
    }

    public function render()
    {
        $livro = Livro::findOrFail($this->livroId);

        return view('livewire.biblioteca.livros.solicitar-alerta', [
            'livro' => $livro,
        ]);
    }
}
