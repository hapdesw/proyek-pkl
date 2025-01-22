<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
    <section class="relative h-screen">
        <!-- Overlay untuk blur -->
        <div class="absolute inset-0 bg-overlay"></div>

        <!-- Login -->
        <div class="relative flex flex-col items-center justify-center h-full px-6 py-6">
            <div class="w-full max-w-sm bg-white rounded-lg shadow dark:border dark:bg-gray-800/80 dark:border-gray-700">
                <h1 class="text-xl pt-6 pb-0 font-bold leading-tight tracking-tight text-slate-600 md:text-xl dark:text-white text-center">
                    Sistem Layanan Data dan Informasi
                </h1>
                <div class="p-4 space-y-2 md:space-y-6 sm:p-8">
                    <!-- Form Login -->
                    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Username -->
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-black dark:text-white">Username</label>
                            <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="username" :value="old('username')" required autofocus autocomplete="username">
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-black dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required autocomplete="current-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-800 ease-out duration-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            {{ __('Log in') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>