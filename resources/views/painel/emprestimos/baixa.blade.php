@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Baixa em parcelas: <b>#{{$editar->id}}</b></h1>
    </div><!-- /.col -->

    <div class="col-sm-6 text-right">
        <a href="{{route('painel.emprestimos.index')}}" class="ml-3"><i class="fa fa-undo-alt"></i> Emprestimos</a>
    </div>
@stop

@section('conteudo')
@if (session('salvo'))
<div class="alert alert-success">
    {{ session('salvo') }}
</div>
@endif

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            Cliente: {{(isset($cliente) ? $cliente->name : '')}} | CPF: {{(isset($cliente) ? $cliente->cpf : '')}}
        </h3>

        <div class="card-tools">
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="spinner-border text-primary carregando" role="status">
                    <span class="sr-only">Carregando...</span>
                </div>

                <div class="parcelas">
                    @if(isset($editar))
                        @foreach($editar->parcelas()->get() as $parcela)                            
                            <div class="row py-1">
                                <div class="col-2 col-md-1">
                                    <span class="form-control text-center" style="padding-left:2px;">{{$parcela->num}}</label>
                                </div>
        
                                <div class="col-5 col-md-5">
                                    <span class="form-control">{{date('d/m/Y', strtotime($parcela->vencimento))}}</span>
                                </div>
        
                                <div class="col-5 col-md-5">
                                    <span class="form-control" >{{inteiroParaReal($parcela->valor)}}</span>
                                </div>
                                
                                <div class="col-1 co-md-1">
                                    @if(!$parcela->baixa)
                                        <a href="{{route('painel.emprestimos.criarBaixa', $parcela->id)}}" class="btn btn-primary" title="Dar baixa"><i class="fa fa-arrow-down"></i></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-lg-3 col-12 my-3" >
                <div class="small-box bg-success ">
                    <div class="inner">
                    <h3><sup style="font-size: 20px">R$</sup><span class="totalEmprestimo"></span>{{$editar->valor_total}}</h3>
    
                    <p>Total Emprestimo</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop