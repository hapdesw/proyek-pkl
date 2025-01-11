<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="m-0 p-0 h-screen flex">
    <div class="flex w-full h-full">
        <!-- Bagian Kiri: Gambar -->
        <div class="flex-1 bg-blue-100">
            <img src="{{ asset('img/bmkg.jpg') }}" alt="BMKG Building" class="w-full h-full object-cover">
        </div>

        <!-- Bagian Kanan: Login -->
        <div class="flex-1 flex flex-col justify-center p-10">
            <h1 class="text-2xl font-bold mb-6 text-gray-700">
                Sistem Informasi Pengajuan Permohonan Layanan
            </h1>
            <form class="space-y-6">
                <div>
                    <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
                    <input type="text" id="username" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan username">
                </div>
                <div>
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" id="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan Password">
                </div>
                <div class="flex justify-between items-center">
                    <label class="flex items-center text-gray-600">
                        <input type="checkbox" class="mr-2"> Ingat Saya
                    </label>
                    <a href="#" class="text-blue-500 hover:underline">Lupa Kata Sandi?</a>
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
