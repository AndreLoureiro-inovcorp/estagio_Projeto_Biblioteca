<?php

namespace App\Livewire\Biblioteca\admin;

use App\Models\Requisicao;
use Carbon\Carbon;
use Livewire\Component;

class IndicadoresRequisicoes extends Component
{
    /**
     * Calcula os indicadores
     */
    public function render()
    {
        // Indicador 1: Requisições Ativas
        $requisicoesAtivas = Requisicao::where('estado', 'ativa')->count();

        // Indicador 2: Requisições nos últimos 30 dias
        $requisicoesUltimos30Dias = Requisicao::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Indicador 3: Livros entregues hoje
        $livrosEntreguesHoje = Requisicao::whereDate('data_entrega_real', Carbon::today())
            ->where('estado', 'entregue')
            ->count();

        return view('livewire.Biblioteca.admin.indicadores-requisicoes', [
            'requisicoesAtivas' => $requisicoesAtivas,
            'requisicoesUltimos30Dias' => $requisicoesUltimos30Dias,
            'livrosEntreguesHoje' => $livrosEntreguesHoje,
        ]);
    }
}
