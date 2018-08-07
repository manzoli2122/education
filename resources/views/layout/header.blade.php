<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom" id="header">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#">
        <i class="fa fa-bars"></i>
      </a>
    </li>
    @yield('header')
  </ul> 
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    @guest
    <li class="nav-item">
      <a class="nav-link" href="{{env('APP_URL_LOGIN_BAON')}}">Entrar    
        <i class="fa fa-sign-in"></i> 
      </a>
    </li> 
    @else


    <notifications>      </notifications>


    




    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Sair
        <i class="fa fa-sign-out"></i>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
    </li>
    @endguest
  </ul>
</nav>
