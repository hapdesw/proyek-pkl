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
             <div class="border-b border-gray-200 dark:border-gray-700 flex justify-between items-center p-4">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                   Edit Hasil Layanan
                </h1>
                
            </div>
            <form action="{{route ('analis.hasil-layanan.update', ['id' => $permohonan->id, 'pegawai' => request('pegawai')]) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @php
                    $nip_pengunggah = null;
                    $isSuperadmin = Auth::user()->peran === '1111' || session('active_role') === '1111';

                    if ($isSuperadmin) {
                        $nip_pengunggah = request('pegawai');
                    } else {
                        $nip_pengunggah = Auth::user()->pegawai->nip ?? null;
                    }
                @endphp

                 {{-- Hidden input buat nilai pegawai --}}
                <input type="hidden" name="pegawai" value="{{ $nip_analis }}">

                {{-- Jika superadmin, tampilkan dropdown --}}
                @if($isSuperadmin)
                    <div class="mt-4">
                        <label for="pegawai" class="block mb-2 text-sm font-medium text-gray-900">Nama Pegawai Pengunggah:</label>
                         <input type="text" class="text-sm bg-gray-200 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 cursor-not-allowed"
                         value="{{ $nama_analis}}" readonly>
                        {{-- <select name="pegawai" id="pegawai" class="w-full border border-gray-300 rounded p-2">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($daftarPegawai as $pegawai)
                                <option value="{{ $pegawai->nip }}" {{ request('pegawai') == $pegawai->nip ? 'selected' : '' }}>
                                    {{ $pegawai->nama }} ({{ $pegawai->nip }})
                                </option>
                            @endforeach
                        </select> --}}
                    </div>
                @endif

                {{-- Warning jika belum ada pegawai terpilih --}}
                @if(!$nip_pengunggah)
                    <div class="p-3 bg-yellow-100 text-yellow-800 rounded text-sm">
                        ⚠️ NIP pengunggah belum tersedia. Silakan pilih pegawai atau akses halaman dengan query <code>?pegawai=...</code>.
                    </div>
                @endif

                <div class="grid grid-cols-1 mt-5">
                    <!-- Kode Permohonan -->
                    <label for="id_permohonan" class="block mb-2 text-sm font-medium text-gray-900">Kode Permohonan:</label>
                    <input type="text" class="text-sm bg-gray-200 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 cursor-not-allowed" name="id_permohonan" id="id_permohonan" value="{{ $permohonan->kode_permohonan }}" readonly>
                </div>
                <div class="grid grid-cols-1 gap-5">
                    <!-- Unggah File -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">
                            Unggah file
                            <span class="text-redNew !important">*</span>
                        </label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file" name="file_hasil" accept=".pdf,.doc,.docx">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, DOC, DOCX (MAX. 10MB)</p>
                    </div>
                    <div id="file-name" class="mt-2 text-sm text-gray-500 dark:text-gray-400"></div>
                </div>
                <div class="flex items-center justify-center mt-8">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Edit File
                    </button> 
                </div>
            </form>
        </div>    
    </div>
</x-app-layout>
