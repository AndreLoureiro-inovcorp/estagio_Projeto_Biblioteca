<?php

namespace App\Livewire\Biblioteca\Reviews;

use App\Mail\NovaReviewAdmin;
use App\Models\Requisicao;
use App\Models\Review;
use App\Services\LogService;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

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

        LogService::registar(
            'Reviews',
            'Criou review',
            "Review #{$review->id} - {$this->requisicao->livro->nome}"
        );

        session()->flash('success', 'Obrigado pela tua review!');

        return redirect()->route('requisicoes.index');
    }

    public function render()
    {
        return view('livewire.biblioteca.reviews.criar-review');
    }
}
