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
                    Edit Disposisi
                </h3>
            </div>
            <form action="{{route ('kapokja.disposisi.update', ['id' => $permohonan->id]) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 mt-5">
                    <!-- ID Permohonan -->
                    <label for="id_permohonan" class="block mb-2 text-sm font-medium text-gray-900">ID Permohonan:</label>
                    <input type="text" class="text-sm bg-gray-200 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 cursor-not-allowed" name="id_permohonan" id="id_permohonan" value="{{ $permohonan->id }}" readonly>
                </div>
                <div class="grid grid-cols-1 gap-5">
                    <!-- Pegawai 1-->
                    <div>
                        <label for="nip_pegawai1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Lajur Disposisi 1
                            <span class="text-redNew !important">*</span>
                        </label>
                        <select name="nip_pegawai[]" id="nip_pegawai1" class="form-select text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 w-full p-2.5" required>
                            <option value="" disabled selected>--Pilih Pegawai--</option>
                            @foreach ($pegawai as $pg)
                                <option value="{{ $pg->nip }}" {{ (isset($disposisi) && $disposisi->nip_pegawai1 == $pg->nip) ? 'selected' : '' }}>
                                    {{ $pg->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Pegawai 2-->
                    <div>
                        <label for="nip_pegawai2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lajur Disposisi 2</label>
                        <select name="nip_pegawai[]" id="nip_pegawai2" class="form-select text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 w-full p-2.5">
                            <option value="" selected>--Pilih Pegawai--</option>
                            @foreach ($pegawai as $pg)
                                <option value="{{ $pg->nip }}" {{ (isset($disposisi) && $disposisi->nip_pegawai2 == $pg->nip) ? 'selected' : '' }}>
                                    {{ $pg->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Pegawai 3-->
                    <div>
                        <label for="nip_pegawai3" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lajur Disposisi 3</label>
                        <select name="nip_pegawai[]" id="nip_pegawai3" class="form-select text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 w-full p-2.5">
                            <option value="" selected>--Pilih Pegawai--</option>
                            @foreach ($pegawai as $pg)
                                <option value="{{ $pg->nip }}" {{ (isset($disposisi) && $disposisi->nip_pegawai3 == $pg->nip) ? 'selected' : '' }}>
                                    {{ $pg->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Tanggal Disposisi -->
                    <div>
                        <label for="tanggal_disposisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tanggal Disposisi
                            <span class="text-redNew !important">*</span>
                        </label>
                        <input type="date" class="text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="tanggal_disposisi" name="tanggal_disposisi" value="{{ isset($disposisi) ? $disposisi->tanggal_disposisi : '' }}" required>
                    </div>
                </div>
                <div class="flex items-center justify-center mt-8">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Edit Disposisi
                    </button> 
                </div>
            </form>
        </div>    
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const pegawai1 = document.getElementById('nip_pegawai1');
        const pegawai2 = document.getElementById('nip_pegawai2');
        const pegawai3 = document.getElementById('nip_pegawai3');
        const allPegawai = [pegawai1, pegawai2, pegawai3];

        function updateOptions(selectedIndex) {
            const selectedValues = allPegawai.map(select => select.value);
            allPegawai.forEach((select, index) => {
                if (index !== selectedIndex) {
                    Array.from(select.options).forEach(option => {
                        if (selectedValues.includes(option.value) && option.value !== "") {
                            option.hidden = true;
                        } else {
                            option.hidden = false;
                        }
                    });
                }
            });
        }

        allPegawai.forEach((select, index) => {
            select.addEventListener('change', () => updateOptions(index));
        });
    });
    </script>
</x-app-layout>
