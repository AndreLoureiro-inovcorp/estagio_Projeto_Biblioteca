<?php

namespace App\Livewire\Biblioteca\admin;

use App\Mail\LivroDisponivel;
use App\Models\AlertaLivro;
use App\Models\Requisicao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class RequisicaoConfirmarDevolucao extends Component
{
    public $requisicao;

    public $data_entrega_real;

    public $observacoes = '';

    public function mount($requisicao)
    {
        $this->requisicao = Requisicao::with(['user', 'livro.editora', 'livro.autores'])->findOrFail($requisicao);

        if ($this->requisicao->estado !== 'ativa') {
            session()->flash('error', 'Esta requisição já foi processada.');

            return redirect()->route('requisicoes.index');
        }

        $this->data_entrega_real = Carbon::today()->format('Y-m-d');
    }

    protected $rules = [
        'data_entrega_real' => 'required|date|after_or_equal:data_requisicao',
    ];

    protected $messages = [
        'data_entrega_real.required' => 'A data de entrega é obrigatória.',
        'data_entrega_real.date' => 'Data inválida.',
        'data_entrega_real.after_or_equal' => 'A data de entrega não pode ser anterior à data de requisição.',
    ];

    public function confirmar()
    {
        $this->validate();

        $dataRequisicao = Carbon::parse($this->requisicao->data_requisicao);
        $dataEntregaReal = Carbon::parse($this->data_entrega_real);
        $diasDecorridos = $dataRequisicao->diffInDays($dataEntregaReal);

        $this->requisicao->update([
            'data_entrega_real' => $dataEntregaReal,
            'dias_decorridos' => $diasDecorridos,
            'estado' => 'entregue',
        ]);

        $this->requisicao->livro->update(['disponivel' => true]);

        $this->notificarAlertasPendentes();

        session()->flash('message', 'Devolução confirmada com sucesso!');

        return redirect()->route('requisicoes.index');
    }

    public function notificarAlertasPendentes()
    {
        $alertasPendentes = AlertaLivro::pendente()
            ->porLivro($this->requisicao->livro_id)
            ->with('user')
            ->get();

        foreach ($alertasPendentes as $alerta) {
            try {
                Mail::to($alerta->user->email)->send(
                    new LivroDisponivel($this->requisicao->livro, $alerta->user)
                );

                $alerta->marcarComoNotificado();

            } catch (\Exception $e) {
                logger()->error('Erro ao enviar email de alerta: '.$e->getMessage(), [
                    'alerta_id' => $alerta->id,
                    'livro_id' => $this->requisicao->livro_id,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.biblioteca.admin.requisicao-confirmar-devolucao');
    }
}
