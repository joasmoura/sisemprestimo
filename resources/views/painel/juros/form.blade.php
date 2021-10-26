@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">{{(isset($editar) ? 'Editar Taxa' : 'Cadastrar Taxa')}}</h1>
    </div><!-- /.col -->
@stop

@section('conteudo')

@if (session('atualizado'))
    <div class="alert alert-success">
        {{ session('atualizado') }}
    </div>
@endif

    
<form action="{{(isset($editar) ? route("painel.juros.update", $editar->id) : route('painel.juros.store'))}}" method="POST">
    @csrf
    @if(isset($editar))
        @method('PUT')
    @endif
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                {{(isset($editar) ? $editar->taxa : '')}}
            </h3>

            <div class="card-tools">
                <a href="{{route('painel.juros.index')}}"><i class="fa fa-undo-alt"></i> Cadastros</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Taxa</label>
                        <input  type="number" name="taxa" min="1" max="100" required value="{{(isset($editar)  && !empty($editar->taxa) ? $editar->taxa : old('taxa'))}}" class="form-control" placeholder="Taxa">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Valor Inicial</label>
                        <input  type="text" name="valor_inicial" required value="{{(isset($editar) && !empty($editar->valor_inicial) ? $editar->valor_inicial : old('valor_inicial'))}}" class="form-control moeda" placeholder="Valor Inicial">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Valor Final</label>
                        <input  type="text" name="valor_final" required value="{{(isset($editar) && !empty($editar->valor_final) ? $editar->valor_final : old('valor_final'))}}" class="form-control moeda" placeholder="Valor Final">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success" title="Salvar"><i class="fa fa-save"></i> Salvar</button>
        </div>
    </div>
@stop