<?php

namespace App\Livewire\Biblioteca\admin;

use App\Mail\ReviewRecusada;
use App\Models\Review;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Services\LogService;

#[Layout('layouts.app')]
class RecusarReview extends Component
{
    public $reviewId;

    public $justificacao_recusada = '';

    protected $rules = [
        'justificacao_recusada' => 'required|string|min:10',
    ];

    protected $messages = [
        'justificacao_recusada.required' => 'Justificação é obrigatória',
        'justificacao_recusada.min' => 'Justificação deve ter pelo menos 10 caracteres',
    ];

    public function mount(Review $review)
    {
        $this->reviewId = $review->id;
    }

    public function recusar()
    {
        $this->validate();

        $review = Review::findOrFail($this->reviewId);

        $review->recusar($this->justificacao_recusada);

        $review->refresh();

        Mail::to($review->user->email)->send(new ReviewRecusada($review));

        LogService::registar(
            'Reviews',
            'Rejeitou review',
            "Review #{$review->id} - {$review->livro->nome}"
        );

        session()->flash('success', 'Review recusado com sucesso.');

        return redirect()->route('admin.reviews');
    }

    public function render()
    {
        $review = Review::with(['user', 'livro', 'requisicao'])
            ->findOrFail($this->reviewId);

        return view('livewire.biblioteca.admin.recusar-review', [
            'review' => $review,
        ]);
    }
}
