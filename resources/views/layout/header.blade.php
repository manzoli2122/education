  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>


      @yield('header') 
       <!--
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      -->
    </ul>


   

  
    <!-- SEARCH FORM 
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
-->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu 
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"> 
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a> 
        </div>
      </li>
      -->
       @guest
       <li class="nav-item">  
        <a class="nav-link"   href="/home">Entrar <i
          class="fa fa-sign-in"></i></a>
        </li>


        @else
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Sair <i
            class="fa fa-sign-out"></i>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
          
          </li>
      @endguest
<!--
      <li class="nav-item">
         
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
          class="fa fa-sign-out"></i></a>
        </li>
-->
         
           
    </ul>
  </nav>
  <!-- /.navbar -->

