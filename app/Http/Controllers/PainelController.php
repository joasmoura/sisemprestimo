<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PainelController extends Controller
{
    public function index(){
        $user = auth()->user();

        if($user->perfil === 'cliente'){
            $emprestimos_cliente = $user->emprestimos_cliente()->paginate(15);
            return View('painel.index', compact('emprestimos_cliente'));
        }
        return View('painel.index');
    }
}
