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
                    @php
                        $total_emprestado = 0;
                        $total_aposta = 0;
                        $total_juros = 0;
                        $total_recebido = 0;
                        $total_comissao = 0;
                        $total_em_aberto = 0;
                    @endphp

                    @forelse($corretores as $corretor)
                        @php
                            $valor_aposta = 0;
                            $valor_emprestado = 0;
                            $valor_recebido = 0;
                            $valor_comissao = 0;
                            $valor_juros = 0;
                            $valor_em_aberto = 0;

                            $emprestimos = $corretor->emprestimos()->get();
                            if($emprestimos->first()){
                                foreach($emprestimos as $emprestimo){
                                    $valor_emprestado += $emprestimo->valor_total;
                                    $valor_comissao += $emprestimo->comissao_corretor;
                                    $valor_aposta += $emprestimo->valor;
                                    $valor_juros = $valor_emprestado-$valor_aposta;
                                    
                                    $parcelas = $emprestimo->parcelas()->get();
                                    if($parcelas->first()){
                                        foreach($parcelas as $parcela){
                                            $valor_recebido += $parcela->baixa()->sum('valor');
                                        }
                                    }

                                    $valor_em_aberto = $valor_emprestado-$valor_recebido;

                                }
                                $total_emprestado += $valor_emprestado;
                                $total_aposta += $valor_aposta;
                                $total_juros += $valor_juros;
                                $total_recebido += $valor_recebido;
                                $total_comissao += $valor_comissao;
                                $total_em_aberto += $valor_em_aberto;
                            }
                        @endphp

                        <tr>
                            <td>{{$corretor->name}}</td>
                            <td>R$ {{inteiroParaReal($valor_aposta)}}</td>
                            <td>R$ {{inteiroParaReal($valor_emprestado)}}</td>
                            <td>R$ {{inteiroParaReal($valor_juros)}}</td>
                            <td>R$ {{inteiroParaReal($valor_recebido)}}</td>
                            <td>R$ {{inteiroParaReal($valor_comissao)}}</td>
                            <td>R$ {{inteiroParaReal($valor_em_aberto)}}</td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Sem dados para consulta até o momento</td>
                        </tr>
                    @endforelse

                    @if(auth()->user()->perfil === 'admin')
                        <tr>
                            <td><b>TOTAIS</b></td>
                            <td><b>R$ {{inteiroParaReal($total_aposta)}}</b></td>
                            <td><b>R$ {{inteiroParaReal($total_emprestado)}}</b></td>
                            <td><b>R$ {{inteiroParaReal($total_juros)}}</b></td>
                            <td><b>R$ {{inteiroParaReal($total_recebido)}}</b></td>
                            <td><b>R$ {{inteiroParaReal($total_comissao)}}</b></td>
                            <td><b>R$ {{inteiroParaReal($total_em_aberto)}}</b></td>
                            <td></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer">
        {{$corretores->links()}}
    </div>
</div>

@stop