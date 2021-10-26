@if(auth()->user()->perfil === 'admin' )
<li class="nav-item">
    <a href="{{route('painel.usuarios.index')}}" class="nav-link {{(url()->current() === route('painel.usuarios.index') ? 'active' : '')}}">
        <i class="nav-icon fas fa-users"></i>
        <p>Corretores</p>
    </a>
</li>
@endif

@if(auth()->user()->perfil === 'admin' || auth()->user()->perfil === 'corretor')
<li class="nav-item">
    <a href="{{route('painel.clientes.index')}}" class="nav-link {{(url()->current() === route('painel.clientes.index') ? 'active' : '')}}">
      <i class="nav-icon fas fa-user-tie"></i>
      <p>Clientes</p>
    </a>
</li>
@endif

@if(auth()->user()->perfil === 'admin')
<li class="nav-item">
    <a href="{{route('painel.juros.index')}}" class="nav-link {{(url()->current() === route('painel.juros.index') ? 'active' : '')}}">
      <i class="nav-icon fas fa-percentage"></i>
      <p>Tabela Juros</p>
    </a>
</li>
@endif

@if(auth()->user()->perfil === 'admin' || auth()->user()->perfil === 'corretor')
<li class="nav-item">
    <a href="{{route('painel.emprestimos.index')}}" class="nav-link {{(url()->current() === route('painel.emprestimos.index') ? 'active' : '')}}">
      <i class="nav-icon fas fa-wallet"></i>
      <p>Emprestimos</p>
    </a>
</li>
@endif

@if(auth()->user()->perfil === 'admin' || auth()->user()->perfil === 'corretor')
<li class="nav-item">
    <a href="{{route('painel.caixa.index')}}" class="nav-link {{(url()->current() === route('painel.caixa.index') ? 'active' : '')}}">
      <i class="nav-icon fas fa-cash-register"></i>
      <p>Caixa</p>
    </a>
</li>
@endif