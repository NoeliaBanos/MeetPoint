{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
  <title>@yield('title', config('app.name', 'Laravel'))</title>

  {{-- Carga CSS y JS via Vite --}}
  @vite(['resources/js/app.js'])

  <script>
    window.Laravel = {
      csrfToken: '{{ csrf_token() }}'
    };
  </script>
</head>

<body class="d-flex flex-column min-vh-100 font-sans antialiased">

  {{-- Navegación --}}
  @include('layouts.navigation')

  {{-- Contenido principal rellena el espacio disponible --}}
  <main class="flex-fill d-flex flex-column">
    @yield('content')
  </main>

  {{-- Footer siempre al final --}}
  @include('partials.footer')

  {{-- Scripts específicos de cada vista --}}
  @stack('scripts')
</body>
</html>
