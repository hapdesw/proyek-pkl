<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" 
    rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-image: url('/img/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Inter', sans-serif;
        }

        .bg-overlay {
            backdrop-filter: blur(5px);
            background-color: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body>
    <section class="relative min-h-screen">
        <!-- Overlay untuk blur -->
        <div class="absolute inset-0 bg-overlay"></div>

        <!-- Daftar -->
        <div class="relative min-h-screen flex flex-col items-center justify-center px-6 py-12">
            <div class="w-full max-w-sm h-auto bg-white rounded-lg shadow dark:border dark:bg-gray-800/80 dark:border-gray-700">
                <h1 class="text-xl pt-6 pb-0 font-bold leading-tight tracking-tight text-slate-600 md:text-xl dark:text-white text-center">
                    Daftar Akun
                </h1>
                <h1 class="text-xl pt-6 pb-0 font-medium leading-tight tracking-tight text-slate-600 md:text-xl dark:text-white text-center">
                    Sistem Layanan Data dan Informasi
                </h1>
                <div class="p-4 space-y-2 md:space-y-6 sm:p-8">
                    <!-- Form Register -->
                    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('daftar-akun.store') }}" autocomplete="off">
                        @csrf

                        <!-- NIP -->
                        <div>
                            <label for="nip_register" class="block mb-2 text-sm font-medium text-black dark:text-white">NIP <span class="text-red-600">*</span> </label>
                           
                            <input type="text" name="nip_register" id="nip_register" placeholder="nip" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  required>
                            <x-input-error :messages="$errors->get('nip_register')" class="mt-2" />
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username_register" class="block mb-2 text-sm font-medium text-black dark:text-white">Username <span class="text-red-600">*</span></label>
                            
                            <input type="text" name="username_register" id="username_register" placeholder="username" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required >
                            <x-input-error :messages="$errors->get('username_register')" class="mt-2" />
                        </div>

                         <!-- Password -->
                         <div>
                            <label for="password_register" class="block mb-2 text-sm font-medium text-black dark:text-white">Password  <span class="text-red-600">*</span></label>
                           
                            <input type="password" name="password_register" id="password_register" placeholder="••••••••" autocomplete="new-password" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <x-input-error :messages="$errors->get('password_register')" class="mt-2" />
                        </div>

                         <!-- Password confirmation-->
                         <div>
                            <label for="password_register_confirmation" class="block mb-2 text-sm font-medium text-black dark:text-white">Konfirmasi Password  <span class="text-red-600">*</span></label>
                           
                            <input type="password" name="password_register_confirmation" id="password_register_confirmation" placeholder="••••••••" autocomplete="new-password" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <x-input-error :messages="$errors->get('password_register_confirmation')" class="mt-2" />
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-800 ease-out duration-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            {{ __('Daftar') }}
                        </button>
                    </form>
                    {{-- Link untuk kembali ke halama login --}}
                    <div>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Log in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>