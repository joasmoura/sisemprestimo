@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Retiradas</h1>
    </div><!-- /.col -->
@stop

@section('conteudo')

<form action="{{route('painel.caixa.confirmarRetirada', $corretor->id)}}" method="POST">
    @csrf
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Corretor: <b>{{$corretor->name}}</b>
            </h3>

            <div class="card-tools">
                <a href="{{route('painel.caixa.index')}}"><i class="fa fa-undo-alt"></i> Caixa</a>
            </div>
        </div>

        <div class="card-body">
            <input type="text" class="form-control moeda" name="valor" placeholder="R$ 000,00">
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Retirar</button>
        </div>
    </div>
</form>
@stop