<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CaixaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if($user->perfil === 'cliente'){
            return redirect()->route('painel.index');
        }

        $corretores = User::where('perfil', 'corretor')->where(function($query) use($user) {
            if($user->perfil === 'corretor'){
                $query->where('id', $user->id);
            }
            $query->where('status', '1');
        })->with('emprestimos')->paginate(15);
        return View('painel.Caixa.index', compact('corretores'));
    }

    public function retirada($id){
        $corretor = User::find($id);

        if($corretor){
            return View('painel.caixa.retirada', compact('corretor'));
        }else{
            return redirect()->back();
        }
    }

    public function confirmarRetirada($id, Request $request){
        $corretor = User::find($id);

        if($corretor){
            $salvo = $corretor->retiradas()->create([
                'valor' => valorBanco($request->valor)
            ]);

            if($salvo){
                return redirect()->route('painel.caixa.index')->with('salvo', 'Retirada registrada com sucesso!');
            }
        }else{
            return redirect()->back();
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
        //
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
        //
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
        //
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
