<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('node_modules/flowbite/dist/flowbite.js') }}"></script>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="font-family: 'Inter', sans-serif;">
    <div class="flex flex-col min-h-screen" style = "background-color: #E8F5FC">
        <!-- Header -->
        @include('layouts.header')
        @if(Auth::check() && Auth::user()->peran === '1000')
            @include('layouts.header-petugas')
        @elseif(Auth::check() && Auth::user()->peran === '0100')
            @include('layouts.header-kapokja')
        @elseif(Auth::check() && Auth::user()->peran === '0010')
            @include('layouts.header-analis')
        @elseif(Auth::check() && Auth::user()->peran === '0001')
            @include('layouts.header-bendahara')
        @endif
        
        <div class="flex-1">
            <!-- Page Content -->
            {{-- <main class="flex-1 p-6 mb-[40px]">
                @yield('content') 
            </main> --}}
            <main class="flex-1 p-6 pt-16" style = "background-color: #E8F5FC">
                {{ $slot }}
            </main>
        </div>

        <!-- Footer -->
        @include('layouts.footer')
    </div>
</body>
</html>
