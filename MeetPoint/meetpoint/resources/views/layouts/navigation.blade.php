<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand me-4" href="{{ route('index') }}">
            <div style="width: 70px">
                <img src="{{ asset('logo.png') }}" alt="">
            </div>
        </a>

        {{-- Nav links (nunca hacen wrap) --}}
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
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                Ver perfil
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>

    </div>
</nav>
