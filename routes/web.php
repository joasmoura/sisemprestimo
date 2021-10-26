<?php

use App\Http\Controllers\BaixaController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EmprestimosController;
use App\Http\Controllers\JurosController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::name('painel.')->middleware('auth')->prefix('painel')->group(function () {
    Route::get('/', [PainelController::class, 'index'])->name('index');
    Route::get('/usuarios/logout', [UsuariosController::class, 'logout'])->name('usuarios.logout');
    Route::resource('/usuarios', UsuariosController::class);
    Route::resource('/clientes', ClientesController::class);

    Route::get('/juros/taxas', [JurosController::class, 'taxas']);
    Route::resource('/juros', JurosController::class);

    Route::get('/emprestimos/baixa/{id}', [EmprestimosController::class, 'baixa'])->name('emprestimos.baixa');
    Route::get('/emprestimos/{id}/baixar', [EmprestimosController::class, 'criarBaixa'])->name('emprestimos.criarBaixa');
    Route::get('/emprestimos/selecionar-cliente', [EmprestimosController::class, 'selecionarCliente'])->name('emprestimos.selecionar');
    Route::get('/emprestimos/{id}/form', [EmprestimosController::class, 'form'])->name('emprestimos.form');
    Route::resource('/emprestimos', EmprestimosController::class);

    Route::resource('/caixa', CaixaController::class);
    Route::resource('/baixa', BaixaController::class);
});

require __DIR__.'/auth.php';
