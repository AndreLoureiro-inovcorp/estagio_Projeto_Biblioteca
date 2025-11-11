<?php

use App\Http\Controllers\LivroController;
use App\Livewire\Livro\Create;
use App\Livewire\Livro\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/livros', Index::class)->name('livros.index');
Route::get('/livros/create', Create::class)->name('livros.create');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
