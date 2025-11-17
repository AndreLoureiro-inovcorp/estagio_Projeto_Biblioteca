<?php

use App\Livewire\Biblioteca\Autores as LivewireAutores;
use App\Livewire\Biblioteca\Editoras as LivewireEditoras;
use App\Livewire\Biblioteca\Livros as LivewireLivros;
use App\Livewire\Biblioteca\LivroShow;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/livros', LivewireLivros::class)->name('livros.index');
    Route::get('/autores', LivewireAutores::class)->name('autores.index')->middleware('role:admin');
    Route::get('/editoras', LivewireEditoras::class)->name('editoras.index');
    Route::get('/livros/{livro}', LivroShow::class)->name('livros.show');
    
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

