<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if($user->perfil === 'cliente' || $user->perfil === 'corretor'){
            return redirect()->route('painel.index');
        }
        $corretores = User::where('perfil', 'corretor')->paginate(15);
        return View('painel.usuarios.index', compact('corretores'));
    }

    public function perfil(){
        return View('painel.usuarios.perfil');
    }

    public function salvarPerfil(Request $request){
        $user = auth()->user();

        $user->name = $request->name;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $salvo =$user->save();

        if($salvo){
            return redirect()->back()->with('salvo', 'Dados atualizados com sucesso!');

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('painel.usuarios.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = [
            'name' => $request->name,
            'perfil' => $request->perfil,
            'email' => $request->email,
            'username' => $request->username,
            'comissao' => $request->comissao,
            'password' => Hash::make($request->password),
            'user_id' => auth()->user()->id
        ];

        $salvo = User::create($dados);

        if($salvo){
            return redirect()->route('painel.usuarios.index')->with('cadastrado', 'Cadastro realizado com sucesso');
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
        if($user->perfil === 'cliente' || $user->perfil === 'corretor'){
            return redirect()->route('painel.index');
        }
        
        $editar = User::find($id);

        if($editar){
            return View('painel.usuarios.form', compact('editar'));
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

        if($user){            
            $user->name = $request->name;
            $user->perfil = $request->perfil;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->comissao = $request->comissao;

            if(!empty($request->password)){
                $user->password = Hash::make($request->password);            
            }
    
            $salvo = $user->save();
    
            if($salvo){
                return redirect()->back()->with('atualizado', 'Cadastro atualizado com sucesso');
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
                return redirect()->route('painel.usuarios.index')->with('excluido', 'Cadastro excluído com sucesso');
            }
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
