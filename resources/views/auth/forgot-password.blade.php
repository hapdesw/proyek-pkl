<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ganti Kata Sandi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        <!-- Ganti Kata Sandi -->
        <div class="relative min-h-screen flex flex-col items-center justify-center px-6 py-12">
            <div class="w-full max-w-sm h-auto bg-white rounded-lg shadow dark:border dark:bg-gray-800/80 dark:border-gray-700">
                <h1 class="text-xl pt-6 pb-0 font-bold leading-tight tracking-tight text-slate-600 md:text-xl dark:text-white text-center">
                    Ganti Kata Sandi
                </h1>
                <div class="p-4 space-y-2 md:space-y-6 sm:p-8">
                    <!-- Form Ganti Kata Sandi -->
                    <form id="passwordForm" class="space-y-4 md:space-y-6" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <!-- NIP -->
                        <div>
                            <label for="nip" class="block mb-2 text-sm font-medium text-black dark:text-white">NIP <span class="text-red-600">*</span></label>
                            <input type="text" name="nip" id="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <div id="nipError" class="mt-2 text-sm text-red-600"></div>
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-black dark:text-white">Username <span class="text-red-600">*</span></label>
                            <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="Masukkan username" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <div id="usernameError" class="mt-2 text-sm text-red-600"></div>
                        </div>

                        <!-- Password Baru -->
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-black dark:text-white">Password Baru <span class="text-red-600">*</span></label>
                            <input type="password" name="password" id="password" placeholder="••••••••" autocomplete="new-password" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <div id="passwordError" class="mt-2 text-sm text-red-600"></div>
                        </div>

                        <!-- Captcha -->
                        <div>
                            <label for="captcha" class="block mb-2 text-sm font-medium text-black dark:text-white">Captcha
                            <span class="text-red-500 !important">*</span>
                            </label>
                            <img src="{{ captcha_src() }}" alt="captcha" id="captchaImage">
                            <div class="mt-2"></div>
                            <input type="text" name="captcha" id="captcha" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan captcha" required>
                            <div id="captchaError" class="mt-2 text-sm text-red-600"></div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="w-full text-white bg-blue-600 hover:bg-blue-800 ease-out duration-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            {{ __('Ganti Kata Sandi') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#passwordForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    // Reset error messages
                    $('[id$="Error"]').text('');
                    $('#submitBtn').prop('disabled', true);
                    
                    $.ajax({
                        url: "{{ route('password.update') }}",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response.redirect) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                }).then(() => {
                                    window.location.href = response.redirect;
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#submitBtn').prop('disabled', false);
                            
                            if(xhr.status === 422) {
                                // Validasi error
                                const errors = xhr.responseJSON.errors;
                                for (const [key, value] of Object.entries(errors)) {
                                    $(`#${key}Error`).text(value[0]);
                                }
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validasi Gagal',
                                    text: 'Terdapat kesalahan pada inputan Anda',
                                });
                            } else {
                                // Error lainnya
                                const errorMessage = xhr.responseJSON.message || 'Terjadi kesalahan pada server';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: errorMessage,
                                });
                            }
                            
                            // Refresh captcha
                            $('#captchaImage').attr('src', '{{ captcha_src() }}?' + new Date().getTime());
                        }
                    });
                });
                
                @if(old('nip'))
                    $('#nip').val('{{ old('nip') }}');
                @endif
                @if(old('username'))
                    $('#username').val('{{ old('username') }}');
                @endif
            });
        </script>
    </section>
</body>
</html>