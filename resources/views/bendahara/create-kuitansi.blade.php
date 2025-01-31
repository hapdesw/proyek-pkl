<x-app-layout>
    <div class="flex justify-center items-center px-4 lg:px-12">
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden w-full max-w-lg p-4">
            @if ($message = Session::get('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ $message }}',
                    });
                </script>
            @endif
    
            @if($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '{{ $errors->first() }}',
                    });
                </script>
            @endif
            <div class="border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white p-2 pb-3">
                    Unggah Kuitansi
                </h3>
            </div>
            <form action="{{route ('bendahara.kuitansi.store', ['id' => $permohonan->id]) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 mt-5">
                    <!-- ID Permohonan -->
                    <label for="id_permohonan" class="block mb-2 text-sm font-medium text-gray-900">ID Permohonan:</label>
                    <input type="text" class="text-sm bg-gray-200 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 cursor-not-allowed" name="id_permohonan" id="id_permohonan" value="{{ $permohonan->id }}" readonly>
                </div>
                <div class="grid grid-cols-1 gap-5">
                    <!-- Unggah File -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">
                            Unggah file
                            <span class="text-redNew !important">*</span>
                        </label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file" name="file_kuitansi" accept=".pdf">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF (MAX. 10MB)</p>
                    </div>
                    <div id="file-name" class="mt-2 text-sm text-gray-500 dark:text-gray-400"></div>
                </div>
                <div class="flex items-center justify-center mt-8">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Unggah File
                    </button> 
                </div>
            </form>
        </div>    
    </div>
</x-app-layout>
