@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Caixa</h1>
    </div><!-- /.col -->
@stop

@section('conteudo')

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            
        </h3>

        <div class="card-tools">
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor emprestado</th>
                        <th>Total emprestimo</th>
                        <th>Juros</th>
                        <th>Valor recebido</th>
                        <th>Comissão corretor</th>
                        <th>Valor em aberto</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($corretores as $corretor)
                        @php
                            $valor_aposta = 0;
                            $total_emprestado = 0;
                            $total_recebido = 0;
                            $total_comissao = 0;

                            $emprestimos = $corretor->emprestimos()->get();
                            if($emprestimos->first()){
                                foreach($emprestimos as $emprestimo){
                                    $total_emprestado += $emprestimo->valor_total;
                                    $total_comissao += $emprestimo->comissao_corretor;
                                    $valor_aposta += $emprestimo->valor;
                                    
                                    $parcelas = $emprestimo->parcelas()->get();
                                    if($parcelas->first()){
                                        foreach($parcelas as $parcela){
                                            $total_recebido += $parcela->baixa()->sum('valor');
                                        }
                                    }
                                }
                            }
                        @endphp

                        <tr>
                            <td>{{$corretor->name}}</td>
                            <td>R$ {{inteiroParaReal($valor_aposta)}}</td>
                            <td>R$ {{inteiroParaReal($total_emprestado)}}</td>
                            <td>R$ {{inteiroParaReal($total_emprestado-$valor_aposta)}}</td>
                            <td>R$ {{inteiroParaReal($total_recebido)}}</td>
                            <td>R$ {{inteiroParaReal($total_comissao)}}</td>
                            <td>R$ {{inteiroParaReal($total_emprestado-$total_recebido)}}</td>
                            <td></td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer">
        {{$corretores->links()}}
    </div>
</div>

@stop