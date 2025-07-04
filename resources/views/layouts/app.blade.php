<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Layanan Data dan Informasi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('node_modules/flowbite/dist/flowbite.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="font-family: 'Inter', sans-serif;">
    <div class="flex flex-col min-h-screen" style = "background-color: #E8F5FC">
        <!-- Header -->
        @include('layouts.header')
        @if(Auth::check() || session()->has('active_role'))
            @if(Auth::user()->peran === '1000' || session('active_role') === '1000')
                @include('layouts.header-admin')
            @elseif(Auth::user()->peran === '0100' || session('active_role') === '0100')
                @include('layouts.header-pic-ldi')
            @elseif(Auth::user()->peran === '0010' || session('active_role') === '0010')
                @include('layouts.header-analis')
            @elseif(Auth::user()->peran === '0001' || session('active_role') === '0001')
                @include('layouts.header-bendahara')
            @elseif(Auth::user()->peran === '1111' || session('active_role') === '1111')
                @include('layouts.header-superadmin')
            @endif
        @endif

        <div class="flex-1">
            <!-- Page Content -->
            {{-- <main class="flex-1 p-6 mb-[40px]">
                @yield('content') 
            </main> --}}
            <main class="flex-1 px-2 pt-5 pb-0" style = "background-color: #E8F5FC">
                {{ $slot }}
            </main>
        </div>

        <!-- Footer -->
        @include('layouts.footer')
    </div>
</body>
</html>
