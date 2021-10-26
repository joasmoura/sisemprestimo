@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">{{(isset($editar) ? 'Editar Cadastro' : 'Cadastrar Corretor')}}</h1>
    </div><!-- /.col -->
@stop

@section('conteudo')

    @if (session('atualizado'))
        <div class="alert alert-success">
            {{ session('atualizado') }}
        </div>
    @endif

<form action="{{(isset($editar) ? route("painel.usuarios.update", $editar->id) : route('painel.usuarios.store'))}}" method="POST">
    @csrf
    <input type="hidden" name="perfil" value="corretor">
    @if(isset($editar))
        @method('PUT')
    @endif
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                {{(isset($editar) ? $editar->name : '')}}
            </h3>

            <div class="card-tools">
                <a href="{{route('painel.usuarios.index')}}"><i class="fa fa-undo-alt"></i> Cadastros</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome</label>
                        <input  type="text" name="name" required value="{{(isset($editar)  && !empty($editar->name) ? $editar->name : old('name'))}}" class="form-control" placeholder="Nome">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input  type="text" name="telefone" required value="{{(isset($editar) && !empty($editar->telefone) ? $editar->telefone : old('telefone'))}}" class="form-control telefone" placeholder="Telefone">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Comissão</label>
                        <input  type="text" name="comissao" required value="{{(isset($editar) && !empty($editar->comissao) ? $editar->comissao : old('comissao'))}}" class="form-control pencent" placeholder="Comissão">
                    </div>
                </div>

                <div class="col-md-12"></div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome de usuário</label>
                        <input  type="text" name="username" required value="{{(isset($editar) && !empty($editar->username) ? $editar->username : old('username'))}}" class="form-control" placeholder="Nome de usuário">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email</label>
                        <input  type="text" name="email" value="{{(isset($editar) && !empty($editar->email) ? $editar->email : old('email'))}}" class="form-control" placeholder="Email">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Senha</label>
                        <input  type="password" name="password" {{(!isset($editar) ? 'required' : '')}} value="" class="form-control" placeholder="Senha">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success" title="Salvar"><i class="fa fa-save"></i> Salvar</button>
        </div>
    </div>
</form>
@stop