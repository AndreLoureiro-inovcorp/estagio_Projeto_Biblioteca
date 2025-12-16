<?php

namespace App\Livewire\Biblioteca;

use App\Mail\NovaRequisicaoAdmin;
use App\Mail\RequisicaoConfirmada;
use App\Models\Livro;
use App\Models\Requisicao;
use App\Models\User;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class RequisicaoCriar extends Component
{
    public $livro_id = '';

    public $livroSelecionado = null;

    protected $rules = [
        'livro_id' => 'required|exists:livros,id',
    ];

    protected $messages = [
        'livro_id.required' => 'Tens de selecionar um livro.',
        'livro_id.exists' => 'O livro selecionado não existe.',
    ];

    public function updatedLivroId($value)
    {
        if ($value) {
            $this->livroSelecionado = Livro::with(['editora', 'autores'])->find($value);
        } else {
            $this->livroSelecionado = null;
        }
    }

    public function criar()
    {
        $this->validate();

        $user = Auth::user();

        if (! $user) {
            session()->flash('error', 'Tens de estar autenticado para fazer uma requisição.');

            return redirect()->route('login');
        }

        $livro = Livro::findOrFail($this->livro_id);

        if (! $user->podeRequisitar()) {
            session()->flash('error', 'Já tens 3 livros requisitados. Tens de devolver um antes de requisitar outro.');

            return;
        }

        if (! $livro->disponivel) {
            session()->flash('error', 'Este livro não está disponível para requisição.');

            return;
        }

        if ($livro->requisicoes()->where('estado', 'ativa')->exists()) {
            session()->flash('error', 'Este livro já está requisitado por outra pessoa.');

            return;
        }

        $ultima = Requisicao::orderBy('id', 'desc')->first();
        $proximo = $ultima ? intval(substr($ultima->numero_requisicao, 4)) + 1 : 1;

        $numeroRequisicao = 'REQ-'.str_pad($proximo, 4, '0', STR_PAD_LEFT);

        $dataRequisicao = Carbon::today();
        $dataPrevistaEntrega = Carbon::today()->addDays(5);

        $requisicao = Requisicao::create([
            'numero_requisicao' => $numeroRequisicao,
            'user_id' => $user->id,
            'livro_id' => $livro->id,
            'data_requisicao' => $dataRequisicao,
            'data_prevista_entrega' => $dataPrevistaEntrega,
            'estado' => 'ativa',
            'foto_cidadao' => 'https://ui-avatars.com/api/?name='.urlencode($user->name),
        ]);

        $livro->update(['disponivel' => false]);

        LogService::registar(
            'Requisições',
            'Criou requisição',
            "{$requisicao->numero_requisicao} - {$livro->nome}"
        );

        //Mail::to($user->email)->send(new RequisicaoConfirmada($requisicao));

        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NovaRequisicaoAdmin($requisicao));
        }

        session()->flash('message', 'Requisição criada com sucesso! Número: '.$numeroRequisicao);

        return redirect()->route('requisicoes.index');
    }

    public function render()
    {
        $livrosDisponiveis = Livro::with(['editora', 'autores'])
            ->where('disponivel', true)
            ->orderBy('nome')
            ->get();

        return view('livewire.biblioteca.requisicoes.requisicao-criar', [
            'livrosDisponiveis' => $livrosDisponiveis,
        ]);
    }
}
