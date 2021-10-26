<?php

namespace App\Http\Controllers;

use App\Models\Juro;
use Illuminate\Http\Request;

class JurosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juros = Juro::paginate('15');
        return View('painel.juros.index', compact('juros'));
    }

    public function taxas (){
        $taxas = Juro::get();

        return $taxas;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('painel.juros.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $salvo = Juro::create([
            'taxa' => $request->taxa,
            'valor_inicial' => $request->valor_inicial,
            'valor_final' => $request->valor_final,
        ]);

        if ($salvo){
            if($salvo){
                return redirect()->route('painel.juros.index')->with('cadastrado', 'Cadastro realizado com sucesso!');
            }
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
        $editar = Juro::find($id);

        if($editar){
            return View('painel.juros.form', compact('editar'));
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
        $taxa = Juro::find($id);

        if($taxa){
            $taxa->taxa = $request->taxa;
            $taxa->valor_inicial = $request->valor_inicial;
            $taxa->valor_final = $request->valor_final;

            $salvo = $taxa->save();

            if($salvo){
                return redirect()->back()->with('atualizado', 'Cadastro atualizado com sucesso!');
            }
        }else{
            return redirect()->back();
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
        $taxa = Juro::find($id);
        if($taxa){
            $excluido = $taxa->delete();
            if($excluido){
                return redirect()->back()->with('excluido', 'Cadastro excluído com sucesso');
            }
        }
    }
}
