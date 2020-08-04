 
        <!-- Navigation -->
        <h6 class="navbar-heading text-muted">
        @if(auth()->user()->rol=='administrador')
        Gestionar Datos
        @else 
        Menu
        @endif
        </h6>
        <ul class="navbar-nav">
          @include('includes.panel.menu.'.auth()->user()->rol)
             
          <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('formLogout').submit();"> 
              <i class="ni ni-key-25 "></i> Cerrar sesion
            </a>
         <form action="{{ route('logout') }}" method="POST" style="display: none;"id="formLogout">
         @csrf
        </form>
          </li>
          @if(auth()->user()->rol=='administrador')         
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">Reportes</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/reportes/citas/linea') }}">
              <i class="ni ni-collection text-yellow"></i> Frecuencia de citas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/reportes/doctores/barra') }}">
              <i class="ni ni-spaceship text-orange"></i> Medicos mas activos
            </a>
          </li>          
        </ul>
        @endif