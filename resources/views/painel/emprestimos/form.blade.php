@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Formulário de emprestimo</h1>
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

<form name="formEmprestimo" action="{{(isset($editar) ? route("painel.emprestimos.update", $editar->id) : route('painel.emprestimos.store'))}}" method="POST">
    @csrf
    <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
    @if(isset($editar))
        @method('PUT')
    @endif

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Cliente: {{(isset($cliente) ? $cliente->name : '')}} | CPF: {{(isset($cliente) ? $cliente->cpf : '')}}
            </h3>

            <div class="card-tools">
                @if(isset($editar))
                    <a href="{{route('painel.emprestimos.baixa', $editar->id)}}">Baixa</a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Valor</label>
                        <input type="text" required name="valor" value="{{(isset($editar) ? $editar->valor : '')}}" class="form-control moeda" placeholder="Valor">
                        <input type="hidden" name="valor_total" value="{{(isset($editar) ? $editar->valor_total : '')}}">
                    </div>
                </div>

                <div class="col-6 col-md-2">
                    <label>Parcelamento</label>
                    <select name="parcela" class="form-control" required>
                        <option value="">Selecione a parcela</option>
                        @for($i = 1; $i <= 24; $i++)
                            <option value="{{$i}}" {{(isset($editar) && $editar->parcelas === $i ? 'selected' : '')}}>{{$i}}</option>
                        @endfor
                    </select>
                </div>

                <input type="hidden" required name="vencimento" id="vencimento" class="form-control" value="{{(isset($editar) ? date('d-m-Y', strtotime($editar->parcelas()->first()->vencimento)) : date('Y-m-d'))}}" placeholder="Data Vencimento">
                {{-- <div class="col-6 col-md-2">
                    <div class="form-group">
                        <label>Data Vencimento</label>
                        <input type="hidden" required name="vencimento" id="vencimento" class="form-control" value="{{(isset($editar) ? date('d/m/Y', strtotime($editar->parcelas()->first()->vencimento)) : date('Y-m-d'))}}" placeholder="Data Vencimento">
                    </div>
                </div> --}}

                <div class="col-md-2 py-2">
                    <label><br><br></label>
                    <button type="button" class="btn btn-primary gerarParcelas">Gerar Parcelas</button>
                </div>

                <div class="col-md-12">
                    <div class="spinner-border text-primary carregando" role="status">
                        <span class="sr-only">Carregando...</span>
                    </div>

                    <div class="parcelas">
                        @if(isset($editar))
                            @foreach($editar->parcelas()->get() as $parcela)
                                <div class="row py-1">
                                    <div class="col-2 col-md-1">
                                        <input type="hidden" name="guia[{{$parcela->num}}][num_parcela]" value="{{$parcela->num}}">
                                        <span class="form-control text-center" style="padding-left:2px;">{{$parcela->num}}</label>
                                    </div>
            
                                    <div class="col-5 col-md-5">
                                        <input type="text" required name="guia[{{$parcela->num}}][datavencimento]" class="form-control data" value="{{date('d/m/Y', strtotime($parcela->vencimento))}}">
                                    </div>
            
                                    <div class="col-5 col-md-5">
                                        <input type="text" class="form-control moedaMask" readonly name="guia[{{$parcela->num}}][valor]" value="{{$parcela->valor}}">
                                    </div>        
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-lg-3 col-12 my-3 {{(!isset($editar) ? 'boxTotalEmprestimo' : '')}}" >
                    <div class="small-box bg-success ">
                        <div class="inner">
                        <h3><sup style="font-size: 20px">R$</sup><span class="totalEmprestimo"></span>{{(isset($editar) ? $editar->valor_total : '') }}</h3>
        
                        <p>Total Emprestimo</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success btn-block" ><i class="fa fa-check"></i> Concluir Emprestimo</button>
        </div>
    </div>
</form>
@stop