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
                    Edit Pegawai
                </h3>
            </div>
            <form action="{{ route('pic-ldi.kelola-pegawai.update', $pegawai->nip) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 mt-5">
                    <!-- NIP -->
                    <label for="nip_pegawai" class="block mb-2 text-sm font-medium text-gray-900">
                        NIP: 
                        <span class="text-redNew !important">*</span>
                    </label>
                    <input type="text" value="{{ $pegawai->nip }}" class="text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="nip_pegawai" id="nip_pegawai">
                </div>
                <div class="grid grid-cols-1 mt-5">
                    <!-- Nama -->
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">
                        Nama: 
                        <span class="text-redNew !important">*</span>
                    </label>
                    <input type="text" value="{{ $pegawai->nama }}" class="text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" name="nama" id="nama">
                </div>
                <div class="grid grid-cols-1 mt-5">
                    <!-- Peran -->
                    <label for="peran" class="block mb-2 text-sm font-medium text-gray-900">
                        Peran: 
                        <span class="text-redNew !important">*</span>
                    </label>
                    <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownSearchButton">
                        <li>
                            <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input id="checkbox-pic-ldi" type="checkbox" name="peran[]" value="0100" {{ str_contains($pegawai->peran_pegawai, '0100') || str_contains($pegawai->peran_pegawai, '0110') || str_contains($pegawai->peran_pegawai, '0101') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="checkbox-pic-ldi" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">PIC LDI</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input id="checkbox-analis" type="checkbox" name="peran[]" value="0010" {{ str_contains($pegawai->peran_pegawai, '0010') || str_contains($pegawai->peran_pegawai, '0110') || str_contains($pegawai->peran_pegawai, '0011') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="checkbox-analis" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Analis</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input id="checkbox-bendahara" type="checkbox" name="peran[]" value="0001" {{ str_contains($pegawai->peran_pegawai, '0001') || str_contains($pegawai->peran_pegawai, '0101') || str_contains($pegawai->peran_pegawai, '0011') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="checkbox-bendahara" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Bendahara</label>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="flex items-center justify-center mt-8">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Simpan Perubahan
                    </button> 
                </div>
            </form>
        </div>    
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="peran[]"]');
            const max = 2;

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedCount = document.querySelectorAll('input[name="peran[]"]:checked').length;
                    if (checkedCount > max) {
                        this.checked = false;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan!',
                            text: 'Anda hanya dapat memilih maksimal 2 peran.',
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>