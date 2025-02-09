<x-app-layout>
    {{-- Form ajukan permohonan --}}
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12"> 
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden ml-1 mr-1 flex flex-col min-h-screen">
                @if ($message = Session::get('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ $message }}',
                    });
                </script>
            @endif

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '{{ $errors->first() }}',
                    });
                </script>
            @endif
            
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white p-4 pb-3">
                        Pengajuan Permohonan
                    </h3>
                </div>
                <div disabled selected class="space-y-4 p-4 mt-3 text-pretty font-semibold">ID Permohonan {{ $nextID }}</div>
                <form action="{{ route("petugas.permohonan.store") }}" method="POST" class="space-y-4 p-4">
                    @csrf
                    {{-- Data pemohon --}}
                    <div class="grid grid-cols-2 gap-5 w-h-screen">
                        <!-- Nama Pemohon -->
                        <div>
                            <label for="nama_pemohon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nama Pemohon
                                <span class="text-redNew !important">*</span>
                            </label>
                            
                            <input type="text" class="text-sm font_medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="nama_pemohon" name="nama_pemohon" required>
                        </div>
                        <!-- No Hp -->
                        <div>
                            <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                No Hp
                                <span class="text-redNew !important">*</span>
                            </label>
                            
                            <input type="text" class="text-sm font_medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="no_hp" name="no_hp" required>
                        </div>
                        <!-- Asal Instansi -->
                        <div>
                            <label for="instansi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Asal Instansi
                                <span class="text-redNew !important">*</span>
                            </label>
                           
                            <input type="text" class="text-sm font_medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="instansi" name="instansi" required>
                        </div>
                        <!-- Email -->
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="text" class="text-sm font_medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="email" name="email">
                        </div>
                    </div>
                    {{-- Data Permohonan --}}
                    <div class="grid grid-cols-1 gap-5 w-1/2">
                        <!-- Tanggal Diajukan -->
                        <div>
                            <label for="tgl_diajukan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tanggal Diajukan
                                <span class="text-redNew !important">*</span>
                            </label>
                            
                            <input type="date" class="text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="tgl_diajukan" name="tgl_diajukan" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Kategori
                                <span class="text-redNew !important">*</span>
                            </label>
                            
                            <select class="text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="kategori" name="kategori" required>
                                <option value="" disabled selected>--Pilih Kategori--</option>
                                <option value="Berbayar">Berbayar</option>
                                <option value="Nolrupiah">Nol Rupiah</option>
                            </select>
                        </div>    
                        <!-- Jenis Layanan -->
                        <div>
                            <label for="jenis_layanan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Jenis Layanan
                                <span class="text-redNew !important">*</span>
                            </label>
                            
                            <select name="jenis_layanan" id="jenis_layanan" class="form-select text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 w-full p-2.5" required>
                                <option value="" disabled selected>--Pilih Jenis Layanan--</option>
                                @foreach ($jenisLayanan as $layanan)
                                    <option value="{{ $layanan->id }}">{{ $layanan->nama_jenis_layanan }}</option>
                                @endforeach
                            </select>
                        </div>   
                       
                    </div>
                    <div id="skripsiFields" class="grid grid-cols-2 gap-5 mt-5 w-1/2 hidden">    
                        <!-- Rencana Tanggal Pengumpulan Skripsi -->
                        <div>
                            <label for="tgl_rencana" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rencana Tanggal Pengumpulan Skripsi</label>
                            <input type="date" class="text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="tgl_rencana" name="rencana_pengumpulan">
                        </div>
                    
                        <!-- Tanggal Pengumpulan Skripsi -->
                        <div>
                            <label for="tgl_pengumpulan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengumpulan Skripsi</label>
                            <input type="date" class="text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="tgl_pengumpulan" name="tgl_pengumpulan">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-5 mt-5 w-1/2">    
                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Deskripsi
                                <span class="text-redNew !important">*</span>
                            </label>
                            
                            <textarea class="text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="deskripsi" name="deskripsi" rows="7" required></textarea>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 mt-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Ajukan Permohonan
                        </button> 
                    </div>
                </form>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const kategoriSelect = document.getElementById("kategori");
                        const skripsiFields = document.getElementById("skripsiFields");
                
                        kategoriSelect.addEventListener("change", function () {
                            if (kategoriSelect.value === "Nolrupiah") {
                                skripsiFields.classList.remove("hidden"); // Tampilkan input
                            } else {
                                skripsiFields.classList.add("hidden"); // Sembunyikan input
                            }
                        });
                    });
                </script>
            </div>    
        </div>    
    {{-- </div> --}}
</x-app-layout>