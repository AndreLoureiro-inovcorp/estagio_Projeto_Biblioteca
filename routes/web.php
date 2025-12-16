<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Biblioteca\livros\Autores;
use App\Livewire\Biblioteca\livros\Editoras;
use App\Livewire\Biblioteca\livros\Livros;
use App\Livewire\Biblioteca\LivroHistorico;
use App\Livewire\Biblioteca\livros\LivroShow;
use App\Livewire\Biblioteca\Carrinho\VerCarrinho;
use App\Livewire\Biblioteca\Carrinho\CheckoutMorada;
use App\Livewire\Biblioteca\Carrinho\CheckoutPagamento;

use App\Livewire\Biblioteca\admin\LivroCriar;
use App\Livewire\Biblioteca\admin\LivroEditar;
use App\Livewire\Biblioteca\admin\LivrosGerir;
use App\Livewire\Biblioteca\admin\RequisicaoConfirmarDevolucao;
use App\Livewire\Biblioteca\admin\GerirUtilizadores;
use App\Livewire\Biblioteca\admin\UtilizadorHistorico;
use App\Livewire\Biblioteca\admin\PesquisarLivrosApi;
use App\Livewire\Biblioteca\Admin\GerirEncomendas;
use App\Livewire\Biblioteca\Admin\GerirLogs;

use App\Livewire\Biblioteca\RequisicaoCriar;
use App\Livewire\Biblioteca\Requisicoes;

use App\Livewire\Biblioteca\Reviews\CriarReview;
use App\Livewire\Biblioteca\admin\GerirReviews;
use App\Livewire\Biblioteca\admin\RecusarReview;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/biblioteca/livros', Livros::class)->name('livros.index');
    Route::get('/autores', Autores::class)->name('autores.index');
    Route::get('/editoras', Editoras::class)->name('editoras.index');

    Route::get('/biblioteca/livros/{livro}', LivroShow::class)->name('livros.show');

    Route::get('/biblioteca/carrinho', VerCarrinho::class)->name('carrinho.ver');
    Route::get('/biblioteca/checkout', CheckoutMorada::class)->name('checkout.morada');
    Route::get('/biblioteca/checkout/pagamento', CheckoutPagamento::class)->name('checkout.pagamento');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/utilizadores', GerirUtilizadores::class)->name('admin.utilizadores');
    Route::get('/admin/utilizadores/{utilizador}/historico', UtilizadorHistorico::class)->name('admin.utilizador.historico');

    Route::get('/admin/livros', LivrosGerir::class)->name('admin.livros');
    Route::get('/admin/livros/criar', LivroCriar::class)->name('livros.criar');
    Route::get('/admin/livros/{livro}/editar', LivroEditar::class)->name('livros.editar');

    Route::get('/requisicoes/{requisicao}/confirmar-devolucao', RequisicaoConfirmarDevolucao::class)->name('requisicoes.confirmar-devolucao');
    Route::get('/admin/pesquisar-livros-api', PesquisarLivrosApi::class)->name('admin.pesquisar-livros-api');

    Route::get('/admin/reviews', GerirReviews::class)->name('admin.reviews');
    Route::get('/admin/reviews/{review}/recusar', RecusarReview::class)->name('admin.reviews.recusar');

    Route::get('/admin/encomendas', GerirEncomendas::class)->name('admin.encomendas');

    Route::get('/admin/logs', GerirLogs::class)->name('admin.logs');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/requisicoes', Requisicoes::class)->name('requisicoes.index');
    Route::get('/requisicoes/criar', RequisicaoCriar::class)->name('requisicao.criar');

    Route::get('/livros/{livro}/historico', LivroHistorico::class)->name('livros.historico');

    Route::get('/reviews/criar/{requisicao}', CriarReview::class)->name('reviews.criar');
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
