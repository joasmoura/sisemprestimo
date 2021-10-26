@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Extrato de pagamento: <b>Empréstimo #{{$emprestimo->id}}</b></h1>
    </div><!-- /.col -->

    <div class="col-sm-6 text-right">
        <a href="{{route('painel.emprestimos.index')}}" class="ml-3"><i class="fa fa-undo-alt"></i> Emprestimos</a>
    </div>
@stop

@section('conteudo')
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            Cliente: {{(isset($emprestimo) ? $emprestimo->cliente->name : '')}} | CPF: {{(isset($emprestimo) ? $emprestimo->cliente->cpf : '')}}
        </h3>

        <div class="card-tools">
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Parcela</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Recebedor</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($parcelas as $p)
                        @php
                            $baixa = $p->baixa
                        @endphp

                        @if($baixa)
                            <tr>
                                <td>{{$p->num}}</td>
                                <td>{{date('d/m/Y', strtotime($baixa->created_at))}}</td>
                                <td>R$ {{inteiroParaReal($baixa->valor)}}</td>
                                <td>{{$baixa->recebedor->name}}</td>
                            </tr>                            
                        @endif
                    @empty
                        <tr>
                            <td colspan="3">Sem dados para mostrar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop