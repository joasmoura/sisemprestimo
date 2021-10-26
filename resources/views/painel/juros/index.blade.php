@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Tabela de Juros</h1>
    </div><!-- /.col -->
@stop

@section('conteudo')
    @if (session('cadastrado'))
    <div class="alert alert-success">
        {{ session('cadastrado') }}
    </div>
    @endif

    @if (session('excluido'))
    <div class="alert alert-success">
        {{ session('excluido') }}
    </div>
    @endif

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                
            </h3>

            <div class="card-tools">
                <div>
                    <a href="{{route('painel.juros.create')}}" class="ml-3"><i class="fa fa-plus"></i> Juros</a>
                </div>  
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Valor Inicial</th>
                            <th>Valor Final</th>
                            <th>% Taxa</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($juros as $juro)
                            <tr>
                                <td>R$ {{inteiroParaReal($juro->valor_inicial)}}</td>
                                <td>R$ {{inteiroParaReal($juro->valor_final)}}</td>
                                <td>{{$juro->taxa}}</td>
                                <td class="d-flex flex-row justify-items-center">
                                    <a href="{{route('painel.juros.edit', $juro->id)}}" class="btn btn-primary btn-sm" title="Editar Taxa"><i class="fa fa-edit"></i></a>

                                    <form action="{{route('painel.juros.destroy', $juro->id)}}" name="excluir" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm ml-1" title="Excluir Taxa"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Não existem taxas cadastradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop