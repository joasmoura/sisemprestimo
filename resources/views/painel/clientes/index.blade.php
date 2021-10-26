@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Clientes</h1>
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
                <div class="d-flex flex-row justify-items-center">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" name="nome" class="form-control float-right" placeholder="Cliente">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <a href="{{route('painel.clientes.create')}}" class="ml-3"><i class="fa fa-plus"></i> Cliente</a>
                    </div>
                </div>
            </div>
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
                                <a href="{{route('painel.clientes.edit', $cliente->id)}}" class="btn btn-primary btn-sm" title="Editar Cliente"><i class="fa fa-edit"></i></a>

                                <form action="{{route('painel.clientes.destroy', $cliente->id)}}" name="excluir" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm ml-1" title="Excluir Cliente"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">Não existem clientes cadastrados</td>
                            </tr>
                        @endforelse
                    </tbody>                
                </table>
            </div>
        </div>

        <div class="card-footer clearfix">
            {{$clientes->links()}}
        </div>
    </div>
@stop