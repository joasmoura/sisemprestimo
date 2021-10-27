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


        $emprestimosHoje = 0;
        $entradasHoje = 0;
        if(auth()->user()->perfil =='admin'){
            $emprestimosHoje = Emprestimo::sum('valor_total');
            $entradasHoje = Baixa::sum('valor');
        }else{
            $emprestimos = $user->emprestimos()->with('parcelas')->get();

            if($emprestimos->first()){
                foreach($emprestimos as $em){
                    $emprestimosHoje += $em->valor_total;
                    $parcelas = $em->parcelas()->get();

                    if($parcelas){
                        foreach($parcelas as $p){
                            if($p->baixa){
                                $entradasHoje += $p->baixa->valor;
                            }
                        }
                    }
                }
            }
        }

        return View('painel.index',compact('entradasHoje', 'emprestimosHoje'));
    }
}
