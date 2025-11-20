<?php

namespace App\Console\Commands;

use App\Mail\RequisicaoLembrete;
use App\Models\Requisicao;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class LembreteRequisicoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lembrete-requisicoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia lembretes de entrega para requisições com devolução prevista para amanhã.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $amanha = Carbon::tomorrow();

        $requisicoes = Requisicao::whereDate('data_prevista_entrega', $amanha)
            ->where('estado', 'ativa')
            ->with(['user', 'livro.editora', 'livro.autores'])
            ->get();

        foreach ($requisicoes as $requisicao) {
            try {
                Mail::to($requisicao->user->email)->send(new RequisicaoLembrete($requisicao));
                $this->info('Email enviado para: '.$requisicao->user->email);
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar lembrete: '.$e->getMessage());
                $this->error('Erro ao enviar para: '.$requisicao->user->email);
            }
        }

        $this->info('Processo de lembrete concluído.');
    }
}
