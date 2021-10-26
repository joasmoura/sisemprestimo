
@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Selecione um cliente</h1>
    </div><!-- /.col -->

    <div class="col-sm-6 text-right">
        <a href="{{route('painel.emprestimos.selecionar')}}" class="ml-3"><i class="fa fa-plus"></i> Emprestimo</a>
    </div>
@stop

@section('conteudo')
    <div class="card card-default">
        <div class="card-header">
            <form method="GET" class="d-flex flex-row">
                <div class="input-group input-group-sm" >
                    <input type="text" class="form-control" required name="nome" value="{{(isset($nome) ? $nome : '')}}"  placeholder="Cliente">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Buscar</button>
                    </span>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Endereço</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($clientes as $cliente)
                        <tr>
                            <td>{{$cliente->name}}</td>
                            <td>{{$cliente->cpf}}</td>
                            <td>{{$cliente->endereco}}, {{$cliente->numero}},  {{$cliente->bairro}}</td>
                            <td class="d-flex flex-row justify-items-center">
                                <a href="{{route('painel.emprestimos.form', $cliente->id)}}" class="btn btn-primary btn-sm" title="Formulário emprestimo"><i class="fa fa-money-check-alt"></i> Emprestar</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">Pesquise um cliente</td>
                            </tr>
                        @endforelse
                    </tbody>                
                </table>
            </div>
        </div>

        <div class="card-footer clearfix">
            @if($clientes)
                {{$clientes->appends($nome)->links()}}
            @endif
        </div>
    </div>
@stop