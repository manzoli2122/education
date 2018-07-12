<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title> SGPM-EDU </title>
 
  <link href="{{ mix('css/fonts.css') }}" rel="stylesheet" type="text/css"/>

  <link href="{{ mix('css/adminlte.css') }}" rel="stylesheet" type="text/css"/>
   
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
 
    @include('layout.header')
 
    @include('layout.sidebar')
  


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Starter Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Card title</h5> 
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-body">
                <h5 class="card-title">Card title</h5> 
              </div>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6> 
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6> 
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar  
  <aside class="control-sidebar control-sidebar-dark"> 
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
   /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer"> 
    <div class="float-right d-none d-sm-inline">
      Versão 0.0.1
    </div> 
    <strong>Copyright &copy; 2018 <a href="#">SGPM-EDU</a>.</strong> Todos Direitos Reservados.
  </footer>
</div>
<!-- ./wrapper -->




<!-- REQUIRED SCRIPTS -->
  
<!-- jQuery  Bootstrap  -->
<script src="{{ mix('js/vendor.js') }}" type="text/javascript"></script>

<!-- AdminLTE App  -->
<script src="{{ mix('js/adminlte.js') }}" type="text/javascript"></script>


</body>
</html>
