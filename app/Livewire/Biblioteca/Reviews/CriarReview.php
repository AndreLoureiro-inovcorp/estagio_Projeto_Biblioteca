<?php

namespace App\Livewire\Biblioteca\Reviews;

use App\Models\Requisicao;
use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Mail\NovaReviewAdmin;
use Illuminate\Support\Facades\Mail;

#[Layout('layouts.app')]
class CriarReview extends Component
{
    public $requisicao;

    public $classificacao = 5;

    public $comentario = '';

    protected $rules = [
        'classificacao' => 'required|between:1,5',
        'comentario' => 'required|min:5',
    ];

    public function mount(Requisicao $requisicao)
    {
        $this->requisicao = $requisicao;

        if ($this->requisicao->user_id != auth()->id()) {
            abort(403);
        }

        if ($this->requisicao->estado != 'entregue') {
            session()->flash('error', 'Tens de devolver o livro antes de avaliar.');

            return redirect()->route('requisicoes.index');
        }

        if ($this->requisicao->review()->exists()) {
            session()->flash('error', 'Já fizeste uma review deste livro.');

            return redirect()->route('requisicoes.index');
        }
    }

    public function salvar()
    {
        $this->validate();

        $review = Review::create([
            'requisicao_id' => $this->requisicao->id,
            'livro_id' => $this->requisicao->livro_id,
            'user_id' => auth()->id(),
            'classificacao' => $this->classificacao,
            'comentario' => $this->comentario,
        ]);

        Mail::to('admin@biblioteca.pt')->send(new NovaReviewAdmin($review));

        session()->flash('success', 'Obrigado pela tua review!');

        return redirect()->route('requisicoes.index');
    }

    public function render()
    {
        return view('livewire.biblioteca.reviews.criar-review');
    }
}
