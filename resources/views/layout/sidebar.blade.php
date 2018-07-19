  <aside class="main-sidebar sidebar-light-warning elevation-4">
   
    <a href="/home" class="bg-white brand-link ">
      <img src="img/brasao-pmes.png" alt="SGPM-EDU" class="brand-image" >   
      <span class="brand-text font-weight-light"><b>SGPM-EDU</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      
      @if( Auth::user() )
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="img/avatar.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{   Auth::user()->name   }}</a>
          </div>
        </div>
      @endif



 

      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="nav-icon fa fa-home  "></i>
              <p>
                Principal 
              </p>
            </a>
          </li>


           @if(Route::getRoutes()->hasNamedRoute('disciplina.index'))
             <li class="nav-item">
              <a href="{{ route('disciplina.index')}}" class="nav-link active">
                <i class="nav-icon fa fa-book fa-lg fa-2x  "></i>
                <p>
                  Disciplina
                  <span class="right badge badge-danger">New</span>
                </p>
              </a>
            </li>  
            @endif 
             

            <li class="nav-item has-treeview ">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-lock"></i>
                <p>
                  Segurança
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                 
                
                @if(Route::getRoutes()->hasNamedRoute('permissao.index'))
                    <li class="nav-item">
                    <a href="{{ route('permissao.index')}}" class="nav-link ">
                      <i class="nav-icon fa fa-unlock fa-lg fa-2x  "></i>
                      <p>
                        Permissão
                        <span class="right badge badge-danger">New</span>
                      </p>
                    </a>
                  </li>  
                  @endif 

                  @if(Route::getRoutes()->hasNamedRoute('perfil.index'))
                  <li class="nav-item">
                    <a href="{{ route('perfil.index')}}" class="nav-link ">
                      <i class="nav-icon fa fa-id-card fa-lg fa-2x  "></i>
                      <p>
                        Perfil
                        
                      </p>
                    </a>
                  </li>  
                  @endif 


                  @if(Route::getRoutes()->hasNamedRoute('usuario.index'))
                  <li class="nav-item">
                  <a href="{{ route('usuario.index')}}" class="nav-link ">
                    <i class="nav-icon fa fa-users fa-lg fa-2x  "></i>
                    <p>
                      Usuário
                        
                    </p>
                  </a>
                </li>  
                @endif 


                
                 
              </ul>
            </li>
      








            


           
           



        </ul>
      </nav>
    </div>
  </aside>
