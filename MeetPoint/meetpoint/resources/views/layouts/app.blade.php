<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <!-- Styles & Scripts -->
  @vite([
  'resources/js/app.js'
])
<script>
    window.Laravel = {
      csrfToken: '{{ csrf_token() }}'
    };
</script>
</head>
{{-- class="page-wrapper" --}}
<body class="font-sans antialiased d-flex flex-column page-wrapper">
 
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
    
</html>
