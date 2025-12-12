<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CarrinhoAbandonado extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $itensCarrinho;

    public $totalCarrinho;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $itensCarrinho, $totalCarrinho)
    {
        $this->user = $user;
        $this->itensCarrinho = $itensCarrinho;
        $this->totalCarrinho = $totalCarrinho;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tens livros no carrinho!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.carrinho-abandonado',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
