@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">{{(isset($editar) ? 'Editar Cadastro' : 'Cadastrar Cliente')}}</h1>
    </div><!-- /.col -->
@stop

@section('conteudo')

@if (session('atualizado'))
    <div class="alert alert-success">
        {{ session('atualizado') }}
    </div>
@endif

<form action="{{(isset($editar) ? route("painel.clientes.update", $editar->id) : route('painel.clientes.store'))}}" method="POST">
    @csrf
    <input type="hidden" name="perfil" value="cliente">
    @if(isset($editar))
        @method('PUT')
    @endif
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                {{(isset($editar) ? $editar->name : '')}}
            </h3>

            <div class="card-tools">
                <a href="{{route('painel.clientes.index')}}"><i class="fa fa-undo-alt"></i> Cadastros</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome</label>
                        <input  type="text" name="name" required value="{{(isset($editar)  && !empty($editar->name) ? $editar->name : old('name'))}}" class="form-control" placeholder="Nome">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>CPF</label>
                        <input  type="text" name="cpf" required value="{{(isset($editar) && !empty($editar->cpf) ? $editar->cpf : old('cpf'))}}" class="form-control cpf" placeholder="CPF">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input  type="text" name="telefone" required value="{{(isset($editar) && !empty($editar->telefone) ? $editar->telefone : old('telefone'))}}" class="form-control telefone" placeholder="Telefone">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input  type="text" name="endereco" required value="{{(isset($editar) && !empty($editar->endereco) ? $editar->endereco : old('endereco'))}}" class="form-control" placeholder="Endereço">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Número</label>
                        <input  type="text" name="numero" value="{{(isset($editar) && !empty($editar->numero) ? $editar->numero : old('numero'))}}" class="form-control" placeholder="Número">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input  type="text" name="bairro" required value="{{(isset($editar) && !empty($editar->bairro) ? $editar->bairro : old('bairro'))}}" class="form-control" placeholder="Bairro">
                    </div>
                </div>

                <div class="col-md-12"></div>


                <input  type="hidden" name="username" value="{{(isset($editar) && !empty($editar->username) ? $editar->username : old('username'))}}">
                {{-- <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome de usuário</label>
                        <input  type="text" name="username" required value="{{(isset($editar) && !empty($editar->username) ? $editar->username : old('username'))}}" class="form-control" placeholder="Nome de usuário">
                    </div>
                </div> --}}

                
                <input  type="hidden" name="email" value="{{(isset($editar) && !empty($editar->email) ? $editar->email : old('email'))}}">
                {{-- <div class="col-md-4">
                    <div class="form-group">
                        <label>Email</label>
                        <input  type="text" name="email" value="{{(isset($editar) && !empty($editar->email) ? $editar->email : old('email'))}}" class="form-control" placeholder="Email">
                    </div>
                </div> --}}

                <input  type="hidden" name="password" value="123456789" class="form-control">
                {{-- <div class="col-md-4">
                    <div class="form-group">
                        <label>Senha</label>
                        <input  type="password" name="password" {{(!isset($editar) ? 'required' : '')}} value="" class="form-control" placeholder="Senha">
                    </div>
                </div> --}}

                @if(auth()->user()->perfil === 'admin')
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Corretor</label>
                            <select name="user_id" class="form-control">
                                <option value=""></option>

                                @forelse($corretores as $corretor)
                                    <option value="{{$corretor->id}}">{{$corretor->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success" title="Salvar"><i class="fa fa-save"></i> Salvar</button>
        </div>
    </div>
</form>
@stop