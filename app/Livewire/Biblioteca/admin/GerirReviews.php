<?php

namespace App\Livewire\Biblioteca\admin;

use App\Mail\ReviewAprovada;
use App\Models\Review;
use App\Services\LogService;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class GerirReviews extends Component
{
    public function aprovar($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        $review->aprovar();

        LogService::registar(
            'Reviews',
            'Aprovou review',
            "Review #{$review->id} - {$review->livro->nome}"
        );

        Mail::to($review->user->email)->send(new ReviewAprovada($review));

        session()->flash('success', 'Review aprovado com sucesso!');
    }

    public function eliminar($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        $nomeUser = $review->user->name;
        $nomeLivro = $review->livro->nome;

        $review->delete();

        session()->flash('success', "Review de {$nomeUser} sobre '{$nomeLivro}' foi eliminada. O utilizador pode agora submeter uma nova review.");
    }

    public function render()
    {
        $reviews = Review::whereIn('estado', ['suspenso', 'recusado'])->with(['user', 'livro', 'requisicao'])->latest()->get();

        return view('livewire.biblioteca.admin.gerir-reviews', [
            'reviews' => $reviews,
        ]);
    }
}
