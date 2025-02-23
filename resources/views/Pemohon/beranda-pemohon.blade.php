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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body class="font-sans antialiased" style="font-family: 'Inter', sans-serif;">
        @include('layouts.header-pemohon')
        <div class="flex items-center justify-center min-h-screen"  style = "background-color: #E8F5FC">
            @if ($message = Session::get('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ $message }}',
                        });
                    </script>
                @endif

                @if (Session::has('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: '{{ Session::get('error') }}',
                        });
                    </script>
                @endif
            <div class="flex flex-col justify-center items-center">
                <h1 class="font-bold text-center text-3xl mb-3">Selamat Datang!</h1>
                <p class="mb-10 text-lg font-normal">Silahkan klik tombol di bawah ini untuk mengajukan permohonan</p>

                <a href="{{ route('pemohon.permohonan.create') }}" class=" hover:bg-blue-400 bg-blue-300 text-blue-950 hover:text-blue-950 text-xl font-semibold rounded-lg shadow-lg w-72 h-48 flex flex-col items-center justify-center  transition">
                        <svg class="w-12 h-12 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7h1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h11.5M7 14h6m-6 3h6m0-10h.5m-.5 3h.5M7 7h3v3H7V7Z"/>
                        </svg> 
                        Form Ajukan Permohonan  
                </a>
            </div>
        </div>
        <div class="flex-1"></div>
        @include('layouts.footer')
    </body>    
</html>