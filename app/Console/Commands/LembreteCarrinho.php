<?php

namespace App\Console\Commands;

use App\Mail\CarrinhoAbandonado;
use App\Models\CarrinhoItem;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LembreteCarrinho extends Command
{
    protected $signature = 'carrinho:lembrete';

    protected $description = 'Envia um email para utilizadores com carrinho abandonado há mais de 1 hora';

    public function handle()
    {
        $carrinhos = CarrinhoItem::with(['user', 'livro'])->where('created_at', '<=', now()->subHour())->get()->groupBy('user_id'); 

        if ($carrinhos->isEmpty()) {
            return Command::SUCCESS;
        }

        foreach ($carrinhos as $userId => $itens) {
            $user = User::find($userId);
            if (! $user) {
                continue;
            }

            $total = $itens->sum(fn ($item) => $item->quantidade * $item->livro->preco);

            Mail::to($user->email)->send(
                new CarrinhoAbandonado($user, $itens, $total)
            );
        }

        return Command::SUCCESS;
    }
}
