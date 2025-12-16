<?php

namespace App\Livewire\Biblioteca;

use App\Models\Livro;
use App\Models\Requisicao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Services\LogService;

class RequisitarLivroDireto extends Component
{
    public $livroId;

    public function mount($livroId)
    {
        $this->livroId = $livroId;
    }

    public function requisitar()
    {
        $livro = Livro::findOrFail($this->livroId);

        if (! $livro->disponivel) {
            session()->flash('erro', 'O livro já está requisitado.');

            return;
        }

        $requisicao = Requisicao::create([
            'livro_id' => $livro->id,
            'user_id' => Auth::id(),
            'estado' => 'ativa',
            'data_requisicao' => now(),
            'data_prevista_entrega' => Carbon::now()->addDays(5),
            'numero_requisicao' => 'REQ-'.str_pad(Requisicao::max('id') + 1, 4, '0', STR_PAD_LEFT),
        ]);

        $livro->update(['disponivel' => false]);

        LogService::registar(
            'Requisições',
            'Criou requisição',
            "{$requisicao->numero_requisicao} - {$livro->nome}"
        );

        return redirect()->route('livros.show', $livro->id)->with('sucesso', 'Livro requisitado com sucesso.');
    }

    public function render()
    {
        return view('livewire.biblioteca.requisicoes.requisitar-livro-direto');
    }
}
