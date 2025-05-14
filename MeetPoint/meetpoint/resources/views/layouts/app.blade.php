<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

<style>
    @font-face {
  font-family: 'Montserrat';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url({{ asset("../fonts/Montserrat.ttf") }}) format('truetype');

}
</style>
    <!-- Styles & Scripts -->
  @vite([
  'resources/js/app.js'
])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

      
   @include('layouts.navigation')

        {{-- Encabezado opcional --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Contenido principal (siempre visible) --}}
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
