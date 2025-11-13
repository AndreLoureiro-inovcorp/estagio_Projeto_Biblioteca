<?php

use App\Livewire\Biblioteca\Autores as LivewireAutores;
use App\Livewire\Biblioteca\Editoras as LivewireEditoras;
use App\Livewire\Biblioteca\Livros as LivewireLivros;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/livros', LivewireLivros::class)->name('livros.index');
    Route::get('/autores', LivewireAutores::class)->name('autores.index');
    Route::get('/editoras', LivewireEditoras::class)->name('editoras.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

