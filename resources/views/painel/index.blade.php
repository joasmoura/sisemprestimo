@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Painel</h1>
    </div><!-- /.col -->
@stop

@section('conteudo')
    @if(isset($emprestimos_cliente))
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">
                    Seus emprestimos
                </h3>
        
                <div class="card-tools">
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Total emprestimo</th>
                                <th>Valor quitado</th>
                                <th>Valor em aberto</th>
                                <th>Última Parcela</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($emprestimos_cliente as $emprestimo)
                                @php
                                    $total_quitado = 0;
                                    $parcelas = $emprestimo->parcelas()->get();
                                    if($parcelas->first()){
                                        foreach($parcelas as $parcela){
                                            $total_quitado += $parcela->baixa()->sum('valor');
                                        }
                                    }
                                @endphp

                                <tr>
                                    <td>{{date('d/m/Y', strtotime($emprestimo->created_at))}}</td>
                                    <td>R$ {{inteiroParaReal($emprestimo->valor_total)}}</td>
                                    <td>R$ {{inteiroParaReal($total_quitado)}}</td>
                                    <td>R$ {{inteiroParaReal($emprestimo->valor_total-$total_quitado)}}</td>
                                    <td>{{date('d/m/Y',strtotime($emprestimo->parcelas()->latest()->first()->vencimento))}}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Nenhum emprestimo realizado até o momento</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@stop