<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="BASE" content="{{env('APP_URL')}}">

        <title>{{ config('app.name', 'Laravel') }}</title>

          <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
         <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
              <!-- Left navbar links -->
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
              </ul>
          
              <!-- Right navbar links -->
              <ul class="navbar-nav ml-auto">
          
                <li class="nav-item">
                  <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{route('painel.usuarios.logout')}}" class="nav-link">
                    <i class="fa fa-sign-out-alt"></i>
                  </a>
                </li>
              </ul>
            </nav>
            <!-- /.navbar -->
          
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
              <!-- Brand Logo -->
              <a href="{{route('painel.index')}}" class="brand-link">
                <img src="{{asset('assets/imgs/logo.jpeg')}}" alt="Emprestimos" class="brand-image elevation-3" >
                <span class="brand-text font-weight-light"><br>
                    
                </span>
              </a>
          
              <!-- Sidebar -->
              <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                  <div class="image">
                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="{{auth()->user()->name}}">
                  </div>

                  <div class="info">
                    @if(auth()->user()->perfil)
                      <a href="{{route('painel.usuarios.perfil')}}" class="d-block">{{auth()->user()->name}}</a>
                    @else
                      <a href="#" class="d-block">{{auth()->user()->name}}</a>
                    @endif
                  </div>
                </div>
          
          
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <a href="{{route('painel.index')}}" class="nav-link {{(url()->current() === route('painel.index') ? 'active' : '')}}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Home</p>
                    </a>
                    
                    @include('layouts.menu')
                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
              <!-- /.sidebar -->
            </aside>
          
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

              <!-- Content Header (Page header) -->
              <div class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    @yield('header')
                  </div><!-- /.row -->
                </div><!-- /.container-fluid -->
              </div>
              <!-- /.content-header -->
          
              <!-- Main content -->
              <section class="content">
                <div class="container-fluid">
                  @yield('conteudo')                  
                </div><!-- /.container-fluid -->
              </section>
              <!-- /.content -->
            </div>
          </div>
          <!-- ./wrapper -->

          <!-- jQuery -->
        <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- daterangepicker -->
        <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{url('assets/js/jquery.mask.min.js')}}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <!-- overlayScrollbars -->
        <script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('assets/js/adminlte.js')}}"></script>
        <script src="{{asset('assets/js/scripts.js')}}"></script>
    </body>
</html>

