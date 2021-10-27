<?php

namespace App\Http\Controllers;

use App\Models\Baixa;
use App\Models\Emprestimo;
use Illuminate\Http\Request;

class PainelController extends Controller
{
    public function index(){
        $user = auth()->user();

        if($user->perfil === 'cliente'){
            $emprestimos_cliente = $user->emprestimos_cliente()->paginate(15);
            return View('painel.index', compact('emprestimos_cliente'));
        }


        $entradasHoje = Baixa::whereDate('created_at', date('Y-m-d'))->sum('valor');
        $emprestimosHoje = Emprestimo::whereDate('created_at', date('Y-m-d'))->sum('valor_total');

        return View('painel.index',compact('entradasHoje', 'emprestimosHoje'));
    }
}
