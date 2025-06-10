<!-- MÓVIL: logo + toggler → collapse a la izquierda, fondo blanco -->
<nav class="container navbar d-lg-none navbar-light bg-white border-bottom">
  <div class="container-fluid">
    <!-- Logo siempre visible -->
    <a class="navbar-brand" href="{{ route('index') }}">
      <div style="width: 70px;">
        <img src="{{ asset('logo.png') }}" alt="">
      </div>
    </a>
    <!-- Toggler a la derecha -->
    <button 
      class="navbar-toggler" 
      type="button" 
      data-bs-toggle="collapse" 
      data-bs-target="#mobileNavContent" 
      aria-controls="mobileNavContent" 
      aria-expanded="false" 
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
  <!-- Collapse con fondo blanco y todo el nav dentro -->
  <div class="collapse" id="mobileNavContent">
    <div class="bg-white p-4">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('espacios.index') }}">Espacios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('resenas.index') }}">Reseñas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('contacto.create') }}">Contacto</a>
        </li>
      </ul>
      <hr>
      <ul class="navbar-nav">
        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
          </li>
        @else
          <li class="nav-item dropdown">
            <a 
              class="nav-link dropdown-toggle" 
              href="#" 
              id="userDropdownMobile"
              data-bs-toggle="dropdown" 
              aria-expanded="false"
            >
              @if (auth()->user()->hasVerifiedEmail())
                <img src="{{ asset('images/check.png') }}" alt="Verificado" class="me-2 check">
              @endif
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdownMobile">
              <li>
                <a class="dropdown-item" href="{{ route('profile.show') }}">Ver perfil</a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">Cerrar sesión</button>
                </form>
              </li>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<!-- ESCRITORIO: tu navbar original -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom d-none d-lg-flex">
  <div class="container">
    {{-- Logo --}}
    <a class="navbar-brand me-4" href="{{ route('index') }}">
      <div style="width: 70px">
        <img src="{{ asset('logo.png') }}" alt="">
      </div>
    </a>
    {{-- Nav links --}}
    <ul class="navbar-nav flex-row flex-nowrap me-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('espacios.index') }}">Espacios</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('resenas.index') }}">Reseñas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('contacto.create') }}">Contacto</a>
      </li>
    </ul>
    {{-- Usuario / Login --}}
    <ul class="navbar-nav flex-row flex-nowrap">
      @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
        </li>
      @else
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown"
             data-bs-toggle="dropdown" aria-expanded="false">
            @if (auth()->user()->hasVerifiedEmail())
              <img src="{{ asset('images/check.png') }}" alt="Verificado" class="me-2 check">
            @endif
            {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
              <a class="dropdown-item" href="{{ route('profile.show') }}">Ver perfil</a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Cerrar sesión</button>
              </form>
            </li>
          </ul>
        </li>
      @endguest
    </ul>
  </div>
</nav>
