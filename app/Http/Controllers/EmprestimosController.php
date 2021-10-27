<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Parcelas;
use App\Models\User;
use Illuminate\Http\Request;

class EmprestimosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if($user->perfil === 'cliente'){
            return redirect()->route('painel.index');
        }

        $emprestimos = Emprestimo::with('cliente', 'parcelas')->where(function($query) use($user) {
            if($user->perfil === 'corretor'){
                $query->where('corretor_id', $user->id);
            }
        })->paginate(15);

        return View('painel.emprestimos.index', compact('emprestimos'));
    }

    public function selecionarCliente(Request $request){
        $nome = $request->nome;
        $user = auth()->user();
        $clientes = [];
        if(!empty($nome)){
            $clientes = User::where('perfil', 'cliente')->where(function($query) use($request, $user) {
                $query->where('name', 'like', '%'.$request->nome.'%');
                if($user->perfil === 'corretor'){
                    $query->where('user_id', $user->id);
                }
            })->paginate();
        }
        return View('painel.emprestimos.clientes', compact('clientes', 'nome'));
    }

    public function form($id){
        $cliente = User::find($id);

        if($cliente && $cliente->perfil === 'cliente'){
            return View('painel.emprestimos.form', compact('cliente'));
        }else{
            return redirect()->back();
        }
    }

    public function baixa($id){
        $editar = Emprestimo::with('cliente', 'parcelas')->find($id);

        if($editar){
            $cliente = $editar->cliente;
            return View('painel.emprestimos.baixa', compact('editar','cliente'));
        }else{
            return redirect()->back();
        }
    }

    public function criarBaixa($id, Request $request){
        $parcela = Parcelas::find($id);
        if($parcela){
            $salvo = $parcela->baixa()->create([
                'valor' => $parcela->valor,
                'user_id' => auth()->user()->id,
                'created_at' => $request->created_at. ' '.date('H:i:s')
            ]);

            if($salvo){
                return redirect()->back()->with('salvo', 'Baixa em parcela realizada com sucesso!');
            }
        }else{
            return redirect()->back();
        }
    }

    public function extrato($id){
        $emprestimo = Emprestimo::with('parcelas')->find($id);

        if($emprestimo){
            $parcelas = $emprestimo->parcelas()->with('baixa')->get();
            return View('painel.emprestimos.extrato', compact('emprestimo', 'parcelas'));
        }else{
            return redirect()->route('painel.emprestimos.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $salvo = Emprestimo::create([
            'cliente_id' => $request->cliente_id,
            'valor' => valorBanco($request->valor),
            'valor_total' => valorBanco($request->valor_total),
            'parcelas' => $request->parcela,
            'status' => '2',
            'corretor_id' => auth()->user()->id,
            'comissao_corretor' => (valorBanco($request->valor_total) * (float) auth()->user()->comissao)/100,
        ]);

        if($salvo){
            foreach($request['guia'] as $parcela){
                $salvo->parcelas()->create([
                    'valor' => valorBanco($parcela['valor']),
                    'vencimento' => date('Y-m-d', strtotime($parcela['datavencimento'])),
                    'num' => $parcela['num_parcela'],
                ]);
            }

            return redirect()->route('painel.emprestimos.index')->with('salvo', 'Emprestimo cadastrado com sucesso!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->user();

        if($user->perfil === 'cliente'){
            return redirect()->route('painel.index');
        }

        $editar = Emprestimo::with('cliente', 'parcelas')->find($id);

        if($editar){
            $cliente = $editar->cliente;
            return View('painel.emprestimos.form', compact('editar','cliente'));
        }else{
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $emprestimo = Emprestimo::find($id);

        if($emprestimo){
            $emprestimo->valor = $request->valor;
            $emprestimo->valor_total = valorBanco($request->valor_total);
            $emprestimo->parcelas = $request->parcela;
            $emprestimo->comissao_corretor = (valorBanco($request->valor_total) * (float) auth()->user()->comissao)/100;

            $salvo = $emprestimo->save();

            if($salvo){
                $emprestimo->parcelas()->delete();
                foreach($request['guia'] as $parcela){
                    $emprestimo->parcelas()->create([
                        'valor' => valorBanco($parcela['valor']),
                        'vencimento' => date('Y-m-d', strtotime($parcela['datavencimento'])),
                        'num' => $parcela['num_parcela'],
                    ]);
                }
                return redirect()->route('painel.emprestimos.edit',$id)->with('salvo', 'Emprestimo atualizado com sucesso!');
            }
        }else{
            return redirect()->route('painel.emprestimos.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
