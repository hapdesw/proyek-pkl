<x-app-layout>
    {{-- Form ajukan permohonan --}}
        <div class="relative w-full h-auto max-w-screen-xl mx-auto">
            <div class="relative bg-white p-6 w-full max-w-full rounded-lg shadow-lg">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400"></button>
                    <h4 class="text-center text-2xl mb-6">Pengisian Permohonan</h4>
                    <form method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Nama Pemohon -->
                            <div>
                                <label for="kode_mk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Pemohon</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="kode_mk" name="kode_mk" required>
                            </div>
                            <!-- No Hp -->
                            <div>
                                <label for="jenis_mk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Hp</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="kode_mk" name="kode_mk" required>
                            </div>
                            <!-- Asal Instansi -->
                            <div>
                                <label for="nama_mk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Asal Instansi</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="nama_mk" name="nama_mk" required>
                            
                            </div>
                            <!-- Email -->
                            <div>
                                <label for="sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="sks" name="sks" required>
                            </div>
                            <!-- Tanggal diajukan -->
                            <div>
                                <label for="sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Diajukan</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="sks" name="sks" required>
                            </div>
                            <!-- Kategori -->
                            <div>
                                <label for="sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="sks" name="sks" required>
                            </div>
                            <!-- Jenis Layanan -->
                            <div>
                                <label for="sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Layanan</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="sks" name="sks" required>
                            </div>
                            <!-- Tanggal awal -->
                            <div>
                                <label for="sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Awal</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="sks" name="sks" required>
                            </div>
                            <!-- Tanggal akhir -->
                            <div>
                                <label for="sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Akhir</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="sks" name="sks" required>
                            </div>
                            <!-- Jam awal -->
                            <div>
                                <label for="sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Awal</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="sks" name="sks" required>
                            </div>
                            <!-- Jam Akhir -->
                            <div>
                                <label for="sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Akhir</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="sks" name="sks" required>
                            </div>
                            <!-- Deskripsi -->
                            <div>
                                <label for="sks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="sks" name="sks" required>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 mt-4">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Ajukan Permohonan
                            </button>
                            
                        </div>
                    </form>
            </div>    
        </div>    
    {{-- </div> --}}

</x-app-layout>