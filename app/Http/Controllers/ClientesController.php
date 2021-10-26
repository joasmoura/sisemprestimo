<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class ClientesController extends Controller
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

        $clientes = User::with('corretor')->where(function($query) use($user){
            $query->where('perfil', 'cliente');
            if($user->perfil === 'corretor'){
                $query->where('user_id', $user->id);
            }
        })->paginate(15);

        return View("painel.clientes.index", compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

        if($user->perfil === 'admin'){
            $corretores = User::where('perfil', 'corretor')->get();
            return view('painel.clientes.form', compact('corretores'));
        }else{
            return view('painel.clientes.form');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $dados = [
            'name' => $request->name,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'perfil' => $request->perfil,
            'email' => $request->email,
            'username' => Str::slug($request->name).time(),
            'password' => Hash::make($request->password),
            'user_id' => ($user->perfil === 'admin' ? $request->user_id : auth()->user()->id)
        ];

        $salvo = User::create($dados);

        if($salvo){
            return redirect()->route('painel.clientes.index')->with('cadastrado', 'Cadastro realizado com sucesso!');
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
        $editar = User::find($id);
        $user = auth()->user();

        if($editar){
            if($user->perfil === 'admin'){
                $corretores = User::where('perfil', 'corretor')->get();
                return View('painel.clientes.form', compact('editar','corretores'));
            }else{
                return View('painel.clientes.form', compact('editar'));
            }
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
        $user = User::find($id);
        $logado = auth()->user();

        if($user){            
            $user->name = $request->name;
            $user->cpf = $request->cpf;
            $user->telefone = $request->telefone;
            $user->endereco = $request->endereco;
            $user->numero = $request->numero;
            $user->bairro = $request->bairro;
            $user->perfil = $request->perfil;
            $user->email = $request->email;
            $user->username = $request->username;

            if($logado->perfil === 'admin'){
                $user->user_id = $request->user_id;
            }

            if(!empty($request->password)){
                $user->password = Hash::make($request->password);            
            }
    
            $salvo = $user->save();
    
            if($salvo){
                return redirect()->back()->with('atualizado', 'Cadastro atualizado com sucesso!');
            }
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
        $user = User::find($id);
        if($user){
            $excluido = $user->delete();
            if($excluido){
                return redirect()->back()->with('excluido', 'Cadastro excluído com sucesso');
            }
        }
    }
}
