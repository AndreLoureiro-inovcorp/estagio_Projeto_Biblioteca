<?php

use App\Livewire\Admin\GerirUtilizadores;
use App\Livewire\Admin\UtilizadorHistorico;
use App\Livewire\Biblioteca\Autores;
use App\Livewire\Biblioteca\Editoras;
use App\Livewire\Biblioteca\LivroCriar;
use App\Livewire\Biblioteca\LivroEditar;
use App\Livewire\Biblioteca\LivroHistorico;
use App\Livewire\Biblioteca\Livros;
use App\Livewire\Biblioteca\LivrosGerir;
use App\Livewire\Biblioteca\LivroShow;
use App\Livewire\Biblioteca\RequisicaoConfirmarDevolucao;
use App\Livewire\Biblioteca\RequisicaoCriar;
use App\Livewire\Biblioteca\Requisicoes;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rotas Autenticadas - Todos os Utilizadores

Route::middleware(['auth'])->group(function () {

    Route::get('/livros', Livros::class)->name('livros.index');
    Route::get('/autores', Autores::class)->name('autores.index');
    Route::get('/editoras', Editoras::class)->name('editoras.index');

    Route::get('/livros/{livro}', LivroShow::class)->name('livros.show');
});

// Rotas de Administração - Apenas Admin

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Gestão de Utilizadores
    Route::get('/admin/utilizadores', GerirUtilizadores::class)->name('admin.utilizadores');
    Route::get('/admin/utilizadores/{utilizador}/historico', UtilizadorHistorico::class)->name('admin.utilizador.historico');

    // Gestão de Livros (CRUD)
    Route::get('/admin/livros', LivrosGerir::class)->name('admin.livros');
    Route::get('/admin/livros/criar', LivroCriar::class)->name('livros.criar');
    Route::get('/admin/livros/{livro}/editar', LivroEditar::class)->name('livros.editar');

    // Confirmar Devolução de Requisições
    Route::get('/requisicoes/{requisicao}/confirmar-devolucao', RequisicaoConfirmarDevolucao::class)->name('requisicoes.confirmar-devolucao');
});

// Rotas de Requisições - Todos Autenticados + Verificados

Route::middleware(['auth', 'verified'])->group(function () {

    // Ver requisições - página principal
    Route::get('/requisicoes', Requisicoes::class)->name('requisicoes.index');

    // Criar nova requisição
    Route::get('/requisicoes/criar', RequisicaoCriar::class)->name('requisicao.criar');

    // Histórico de um livro específico
    Route::get('/livros/{livro}/historico', LivroHistorico::class)->name('livros.historico');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('livros.index');
    })->name('dashboard');
});
