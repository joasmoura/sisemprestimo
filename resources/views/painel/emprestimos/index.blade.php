@extends('layouts.painel')

@section('header')
    <div class="col-sm-6">
        <h1 class="m-0">Emprestimos</h1>
    </div><!-- /.col -->

    <div class="col-sm-6 text-right">
        <a href="{{route('painel.emprestimos.selecionar')}}" class="ml-3"><i class="fa fa-plus"></i> Emprestimo</a>
    </div>
@stop

@section('conteudo')

  @if (session('salvo'))
  <div class="alert alert-success">
      {{ session('salvo') }}
  </div>
  @endif

  @if (session('excluido'))
  <div class="alert alert-success">
      {{ session('excluido') }}
  </div>
  @endif

  <div class="row">

    @forelse($emprestimos as $emprestimo)
        <!-- Widget: user widget style 1 -->
        <div class="col-md-4">
          <div class="card card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header {{($emprestimo->status == '1' ? 'bg-warning' : '').($emprestimo->status == '2' ? 'bg-success' : '').($emprestimo->status == '0' ? 'bg-danger' : '') }}">
              <h3 class="widget-user-username">{{$emprestimo->cliente->name}}</h3>
              <h5 class="widget-user-desc">{{$emprestimo->cliente->endereco}}, {{$emprestimo->cliente->numero}}, {{$emprestimo->cliente->bairro}}</h5>
            </div>
            <div class="widget-user-image">
            </div>

            <div class="card-body">
              <a href="{{route('painel.emprestimos.baixa', $emprestimo->id)}}" class="btn btn-block btn-success"><i class="fa fa-arrow-down"></i> Baixa</a>
              <a href="{{route('painel.emprestimos.edit', $emprestimo->id)}}" class="btn btn-block btn-default"><i class="fa fa-edit"></i> Editar</a>
            </div>

            <div class="card-footer">
              <div class="d-flex flex-row  justify-content-between text-center">
                <div><b>Data</b><br> {{date('d/m/Y',strtotime($emprestimo->created_at))}}</div>
                <div><b>Corretor</b><br> {{$emprestimo->corretor->name}}</div>
                <div><b>Vencimento</b><br> {{date('d',strtotime($emprestimo->parcelas()->first()->vencimento))}}</div>
              </div>
              
              <div class="row">
                <div class="col-4 col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">R$ {{inteiroParaReal($emprestimo->valor_total)}}</h5>
                    <span class="description-text">Emprestimo</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-4 col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">
                      @php
                        $parcelas = $emprestimo->parcelas()->get();
                        $total_pago = 0;
                        if($parcelas->first()){
                          foreach($parcelas as $parcela){
                            $total_pago += $parcela->baixa()->sum('valor');
                          }
                        }
                      @endphp

                      R$ {{inteiroParaReal($total_pago)}}
                    </h5>
                    <span class="description-text">Pago</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-4 col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">
                      @php
                        $parcelas = $emprestimo->parcelas()->with('baixa')->get();
                        $baixas = 0;
                        foreach($parcelas as $parcela){
                          $baixas += $parcela->baixa()->count();
                        }
                      @endphp
                      {{$baixas}}/{{$emprestimo->parcelas}}</h5>
                    <span class="description-text">parcelas</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
        </div>
        <!-- /.widget-user -->
      @empty
    @endforelse
  </div>
@stop