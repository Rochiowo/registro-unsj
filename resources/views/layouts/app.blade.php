<!DOCTYPE html>
@php
    $isAnimalsApp = request()->routeIs('animals.*');
    $applicationName = $isAnimalsApp ? 'AnimalsApp' : 'MovieApp';
@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $applicationName }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans text-gray-900 antialiased {{ $isAnimalsApp ? 'bg-emerald-50' : 'bg-gray-100' }}">
        <nav class="text-white shadow {{ $isAnimalsApp ? 'bg-emerald-800' : 'bg-gray-900' }}">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ $isAnimalsApp ? route('animals.index') : url('/') }}" class="text-2xl font-bold">{{ $applicationName }}</a>
            </div>
        </nav>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @yield('content')
        </main>

        <footer class="mt-auto py-6 text-center text-sm text-gray-200 {{ $isAnimalsApp ? 'bg-emerald-900' : 'bg-gray-900' }}">
            &copy; {{ date('Y') }} {{ $applicationName }}. Todos los derechos reservados.
        </footer>
    </body>
</html>
