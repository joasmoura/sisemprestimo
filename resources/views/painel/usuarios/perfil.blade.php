@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Perfil</h1>
    </div><!-- /.col -->

    <div class="col-sm-6 text-right">
        
    </div>
@stop

@section('conteudo')

@if (session('salvo'))
<div class="alert alert-success">
    {{ session('salvo') }}
</div>
@endif

<form method="POST" action="{{route('painel.usuarios.salvarPerfil')}}">
    @csrf
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                {{auth()->user()->name}}
            </h3>

            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" value="{{auth()->user()->name}}" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Senha</label>
                        <input type="password" name="password" value="" class="form-control">
                    </div>
                </div>

            </div>
        </div>
            
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
        </div>
    </div>
</form>
@stop