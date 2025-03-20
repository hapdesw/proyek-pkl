<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite('resources/css/app.css')
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <form id="role-form" action="{{ route('pilih-role') }}" method="POST" class="flex space-x-8">
        @csrf
        <input type="hidden" name="role" id="selected-role">

        <button type="submit" onclick="setRole('0100')" class="bg-white rounded-lg shadow-lg w-64 h-64 flex flex-col items-center justify-center hover:bg-amber-100 transition">
            <div class="text-amber-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>                  
            </div>
            <h2 class="text-xl font-semibold text-gray-800">PIC LDI</h2>
        </button>

        <button type="submit" onclick="setRole('0001')" class="bg-white rounded-lg shadow-lg w-64 h-64 flex flex-col items-center justify-center hover:bg-sky-100 transition">
            <div class="text-sky-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>                  
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Bendahara</h2>
        </button>
    </form>

    <script>
        function setRole(roleCode) {
            document.getElementById('selected-role').value = roleCode;
        }
    </script>
</body>
</html>
