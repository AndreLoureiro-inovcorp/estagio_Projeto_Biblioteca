<?php

use App\Livewire\Biblioteca\Autores as LivewireAutores;
use App\Livewire\Biblioteca\Editoras as LivewireEditoras;
use App\Livewire\Biblioteca\Livros as LivewireLivros;
use App\Livewire\Admin\GerirUtilizadores;
use App\Livewire\Biblioteca\LivroShow;
use App\Livewire\Biblioteca\LivrosGerir;
use App\Livewire\Biblioteca\LivroCriar;
use App\Livewire\Biblioteca\LivroEditar;
use App\Livewire\Biblioteca\Requisicoes;
use App\Livewire\Biblioteca\RequisicaoCriar;
use App\Livewire\Biblioteca\RequisicaoConfirmarDevolucao;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/livros', LivewireLivros::class)->name('livros.index');
    Route::get('/autores', LivewireAutores::class)->name('autores.index');
    Route::get('/editoras', LivewireEditoras::class)->name('editoras.index');
    Route::get('/livros/{livro}', LivroShow::class)->name('livros.show');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/utilizadores', GerirUtilizadores::class)->name('admin.utilizadores');
    Route::get('/admin/livros', LivrosGerir::class)->name('admin.livros');
    Route::get('/admin/livros/criar', LivroCriar::class)->name('livros.criar');
    Route::get('/admin/livros/{livro}/editar', LivroEditar::class)->name('livros.editar');
    Route::get('/requisicoes/{requisicao}/confirmar-devolucao', RequisicaoConfirmarDevolucao::class)->name('requisicoes.confirmar-devolucao');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/requisicoes', Requisicoes::class)->name('requisicoes.index');
    Route::get('/requisicoes/criar', RequisicaoCriar::class)->name('requisicao.criar');
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
