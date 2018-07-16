  <aside class="main-sidebar sidebar-dark-warning elevation-4">
    <a href="/home" class="brand-link">
      <img src="img/pmes.png" alt="SGPM-EDU" class="brand-image elevation-3" style="opacity: .8">   
      <span class="brand-text font-weight-light"><b>SGPM-EDU</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      
      @if( Auth::user() )
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{   Auth::user()->name   }}</a>
          </div>
        </div>
      @endif


      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          @perfil('Admin')
           @if(Route::getRoutes()->hasNamedRoute('disciplina.index'))
             <li class="nav-item">
              <a href="{{ route('disciplina.index')}}" class="nav-link">
                <i class="fa fa-book fa-lg fa-2x text-warning"></i>
                <p>
                  Disciplina
                  <span class="right badge badge-danger">New</span>
                </p>
              </a>
            </li> 
            @endif 
          @endperfil  



        </ul>
      </nav>
    </div>
  </aside>
