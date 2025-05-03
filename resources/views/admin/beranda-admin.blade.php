<x-app-layout>
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden ml-1 mr-1 flex flex-col min-h-screen">
        <div class="overflow-x-auto min-h-screen">
            <div class="relative flex items-center justify-center">
                <h2 class="mt-6 mb-8 text-lg font-semibold absolute left-1/2 transform -translate-x-1/2">
                    Rekap Layanan Tahunan {{ $tahun }}
                </h2>
            
                <div class="ml-auto mr-6 mt-6 mb-8">
                    <!-- Filter Button -->
                    <button id="filterButton" data-dropdown-toggle="dropdownFilters" class="py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 flex items-center">
                        <svg class="h-3.5 w-3.5 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
                        </svg>                                      
                        Pilih Tahun
                    </button>
            
                    <!-- Dropdown Filter -->
                    <div id="dropdownFilters" style="display: none;" class="absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-md p-4 z-50">
                        <h3 class="font-semibold mt-4 mb-2">Pilih Tahun</h3>
                        <select id="yearFilter" class="w-full p-2 border rounded">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunTersedia as $t)
                                <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                
                        <!-- Tombol Terapkan -->
                        <button id="applyFilter" class="mt-4 w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">
                            Terapkan
                        </button>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const filterButton = document.getElementById('filterButton');
                        const dropdownFilters = document.getElementById('dropdownFilters');
                        const yearFilter = document.getElementById('yearFilter');
                        const applyFilter = document.getElementById('applyFilter');
                    
                        // Toggle dropdown when filter button is clicked
                        filterButton.addEventListener('click', function(e) {
                            e.stopPropagation();
                            dropdownFilters.style.display = dropdownFilters.style.display === 'none' ? 'block' : 'none';
                        });
                    
                        // Close dropdown when clicking outside
                        document.addEventListener('click', function(e) {
                            if (!dropdownFilters.contains(e.target) && !filterButton.contains(e.target)) {
                                dropdownFilters.style.display = 'none';
                            }
                        });
                    
                        // Handle apply filter button click
                        applyFilter.addEventListener('click', function() {
                            const selectedYear = yearFilter.value;
                            if (selectedYear) {
                                const url = new URL(window.location.href);
                                url.searchParams.set('tahun', selectedYear);
                                window.location.href = url.toString();
                            }
                            dropdownFilters.style.display = 'none';
                        });
                    
                        // Prevent dropdown from closing when clicking inside it
                        dropdownFilters.addEventListener('click', function(e) {
                            e.stopPropagation();
                        });
                    });
                    </script>
            </div>
            
            

            <!-- Kotak untuk Total -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 ml-6 mr-6">
                <button id="totalPermohonanBtn" class="p-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600" onclick="toggleTable('permohonan')">
                    <p class="text-center">Rekap Total Permohonan</p>
                    <p class="text-center">{{ array_sum($rekapPerBulan['permohonan'] )}}</p>
                </button>
                <button id="totalPemohonBtn" class="p-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600" onclick="toggleTable('pemohon')">
                    <p class="text-center">Rekap Total Pemohon</p>
                    <p class="text-center">{{ array_sum($rekapPerBulan['pemohon']) }}</p>
                </button>
                <button id="totalDisposisiBtn" class="p-4 bg-yellow-400 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-500" onclick="toggleTable('disposisi')">
                    <p class="text-center">Rekap Total Disposisi</p>
                    <p class="text-center">{{ array_sum(array_merge(...array_values($rekapPerBulan['disposisi_per_pegawai']))) }}</p>
                </button>
                <button id="totalLayananBtn" class="p-4 bg-purple-500 text-white font-semibold rounded-lg shadow-md hover:bg-purple-600" onclick="toggleTable('layanan')">
                    <p class="text-center">Rekap Total Kategori Layanan</p>
                    <p class="text-center">{{ array_sum($rekapPerBulan['jenis_layanan_berbayar']) + array_sum($rekapPerBulan['jenis_layanan_nol']) }}</p>
                </button>
                <button id="jenisLayananBtn" class="p-4 bg-orange-500 text-white font-semibold rounded-lg shadow-md hover:bg-orange-600" onclick="toggleTable('jenislayanan')">
                    <p class="text-center">Rekap Total Jenis Layanan</p>
                    <p class="text-center">{{ array_sum(array_merge(...array_values($rekapPerBulan['jenis_layanan_nama']))) }}</p>
                </button>
                <button id="statusBtn" class="p-4 bg-pink-500 text-white font-semibold rounded-lg shadow-md hover:bg-pink-600" onclick="toggleTable('status')">
                    <p class="text-center">Rekap Total Status Permohonan</p>
                    <p class="text-center">{{ array_sum($rekapPerBulan['status_diproses']) + array_sum($rekapPerBulan['status_selesai_dibuat']) + array_sum($rekapPerBulan['status_selesai_diambil']) + array_sum($rekapPerBulan['status_batal']) }}</p>
                </button>
            </div>

            <!-- Rincian Data Permohonan -->
           
            <div id="permohonanTable" class="bg-blue-100 hidden flex flex-col items-center justify-center mt-10 mb-10 mr-52 ml-52 border-blue-500 rounded-lg shadow-md">
                <div class="mb-10 mt-10">
                     @php
                        $namaBulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                    @endphp
                    <!-- Judul Permohonan -->
                    <h3 class="text-center text-lg font-semibold mb-5">Rekap Permohonan</h3>
                    <table class="table-auto  w-80 border-collapse border border-blue-500">
                        <thead>
                            <tr>
                                <th class="border bg-blue-500 border-blue-500 px-4 py-2  text-white text-sm">Bulan</th>
                                <th class="border bg-blue-500 border-blue-500 px-4 py-2 text-white text-sm">Total Permohonan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapPerBulan['permohonan'] as $index => $total)
                                <tr>
                                    <td class="border border-blue-500 px-4 py-2 text-sm">{{ $namaBulan[$index] }}</td>
                                    <td class="border border-blue-500 px-4 py-2 text-sm ">{{ $total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rincian Data Pemohon -->
            <div id="pemohonTable" class="bg-green-100 hidden flex flex-col items-center justify-center mt-10 mb-10 mr-52 ml-52 border-green-500 rounded-lg shadow-md">
                <div class="mb-10 mt-10">
                     @php
                        $namaBulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                    @endphp
                    <!-- Judul Pemohon -->
                    <h3 class="text-center text-lg font-semibold mb-5">Rekap Pemohon</h3>
                    <table class="table-auto  w-80 border-collapse border border-green-500">
                        <thead>
                            <tr>
                                <th class="border bg-green-500 border-green-500 px-4 py-2  text-white text-sm">Bulan</th>
                                <th class="border bg-green-500 border-green-500 px-4 py-2 text-white text-sm">Total Pemohon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapPerBulan['pemohon'] as $index => $total)
                                <tr>
                                    <td class="border border-green-500 px-4 py-2 text-sm">{{ $namaBulan[$index] }}</td>
                                    <td class="border border-green-500 px-4 py-2 text-sm ">{{ $total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rincian Data Disposisi -->
            <div id="disposisiTable" class="bg-yellow-100 hidden flex flex-col items-center justify-center mt-10 mb-10 mx-8 border-yellow-500 rounded-lg shadow-md">
                <div class="mb-10 mt-10 w-full">
                    @php
                        $namaBulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        $namaDisposisi = array_keys($rekapPerBulan['disposisi_per_pegawai']); // Ambil nama-nama disposisi
                    @endphp
            
                    <!-- Judul Disposisi -->
                    {{-- Tombol Export --}}
                    <div class="relative flex items-center justify-center">
                        <h3 class="mt-6 mb-8 text-lg font-semibold absolute left-1/2 transform -translate-x-1/2">Rekap Disposisi</h3>

                        <div class="ml-auto mr-6 mt-6 mb-8">
                            <button id="exportButton" class="py-2 px-4 text-sm font-medium text-white focus:outline-none bg-yellow-500 rounded-lg border border-yellow-500 hover:bg-yellow-600 hover:text-white focus:z-10 focus:ring-4 focus:ring-yellow-200 flex items-center">
                                <svg class="h-3.5 w-3.5 mr-2 text-white hover:gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
                                </svg>                               
                                Export
                            </button>
                            {{-- Pop-up Konfirmasi Export --}}
                            <div id="exportModal" class="fixed inset-0 z-50 flex items-center justify-center hidden" style="margin: 0; padding: 0;">
                                <div class="absolute inset-0 bg-gray-800 bg-opacity-50"></div>
                                <div class="relative bg-white rounded-lg shadow-lg p-6 w-96 m-4">
                                    <!-- Pesan -->
                                    <p class="text-lg font-semibold text-gray-800 mb-4">
                                        Disposisi akan di-export, silahkan pilih format file
                                    </p>
                                    <!-- Tombol Export -->
                                    <div id="exportButtons" class="flex justify-center gap-5 mb-6">
                                        <a href id="pdfExportButton" class="bg-redNew hover:bg-red-300 text-white hover:text-orange-700 font-bold py-2 px-4 rounded">PDF</a>
                                        <a href id="excelExportButton" class="bg-green-500 hover:bg-green-300 text-white hover:text-green-700 font-bold py-2 px-4 rounded">Excel</a>
                                    </div>
                                    <!-- Tombol Batal -->
                                    <button id="closeModal" class="mt-4 w-full bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Batal</button>
                                </div>
                            </div>
                            {{-- Script JavaScript untuk Modal Export--}}
                            <script>
                              document.addEventListener('DOMContentLoaded', function() {
                                // Ambil elemen modal dan tombol
                                const exportModal = document.getElementById('exportModal');
                                const closeModal = document.getElementById('closeModal');
                                const exportButton = document.getElementById('exportButton');
                                const pdfExportButton = document.getElementById('pdfExportButton');
                                const excelExportButton = document.getElementById('excelExportButton');

                                // Fungsi untuk mendapatkan tahun aktif
                                function getCurrentYear() {
                                    // Coba ambil dari URL parameter 'tahun' (yang digunakan di filter)
                                    const urlParams = new URLSearchParams(window.location.search);
                                    const yearFromURL = urlParams.get('tahun');
                                    
                                    // Jika ada di URL, gunakan nilai tersebut
                                    if (yearFromURL) {
                                        console.log('Found year in URL:', yearFromURL);
                                        return yearFromURL;
                                    }
                                    
                                    // Jika tidak ada di URL, coba ambil dari elemen select
                                    const yearFilterElem = document.getElementById('yearFilter');
                                    if (yearFilterElem && yearFilterElem.value) {
                                        console.log('Found year in filter element:', yearFilterElem.value);
                                        return yearFilterElem.value;
                                    }
                                    
                                    // Jika tidak ditemukan di mana pun, kembalikan nilai kosong
                                    console.log('No year found in URL or filter');
                                    return '';
                                }

                                // Fungsi untuk menampilkan modal
                                function showExportModal() {
                                    exportModal.classList.remove('hidden');
                                }

                                // Fungsi untuk menyembunyikan modal
                                function hideExportModal() {
                                    exportModal.classList.add('hidden');
                                }

                                // Fungsi untuk build URL export
                                function buildExportUrl(format) {
                                    const year = getCurrentYear();
                                    let url = '/admin-layanan/beranda/export?format=' + format;
                                    
                                    // Tambahkan year ke URL jika tersedia
                                    if (year && !isNaN(year)) {
                                        // Gunakan 'year' sebagai nama parameter saat mengirim ke controller
                                        url += '&year=' + encodeURIComponent(year);
                                        console.log('Adding year to export URL:', year);
                                    } else {
                                        console.log('No valid year found for export URL');
                                    }
                                    
                                    console.log('Final Export URL:', url);
                                    return url;
                                }

                                // Event listener untuk tombol Export
                                if (exportButton) {
                                    exportButton.addEventListener('click', showExportModal);
                                }

                                // Event listener untuk tombol Batal
                                if (closeModal) {
                                    closeModal.addEventListener('click', hideExportModal);
                                }

                                // Event listener untuk tombol PDF
                                if (pdfExportButton) {
                                    pdfExportButton.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const url = buildExportUrl('pdf');
                                        // Buka di tab baru untuk PDF
                                        window.open(url, '_blank');
                                        hideExportModal();
                                    });
                                }

                                // Event listener untuk tombol Excel
                                if (excelExportButton) {
                                    excelExportButton.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const url = buildExportUrl('excel');
                                        
                                        // Show loading indicator
                                        excelExportButton.innerHTML = '<span class="flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...</span>';
                                        
                                        // Redirect untuk download Excel
                                        window.location.href = url;
                                        
                                        // Reset button after 3 seconds in case download fails
                                        setTimeout(() => {
                                            excelExportButton.innerHTML = 'Excel';
                                        }, 3000);
                                        
                                        hideExportModal();
                                    });
                                }

                                // Tutup modal ketika klik di luar area popup
                                exportModal.addEventListener('click', function(e) {
                                    if (e.target === exportModal) {
                                        hideExportModal();
                                    }
                                });
                            });
                            </script>
                        </div>    
                    </div>
                   
                    <!-- Tabel -->
                    <div class="flex justify-center overflow-x-auto">
                        <table class="table-auto border-collapse border border-yellow-500 mx-auto">
                            <thead>
                                <tr>
                                    <th class="border bg-yellow-500 border-yellow-500 px-4 py-2 text-white text-sm">Nama Pegawai</th>
                                    @foreach ($namaBulan as $bulan)
                                        <th class="border bg-yellow-500 border-yellow-500 px-4 py-2 text-white text-sm">{{ $bulan }}</th>
                                    @endforeach
                                    <th class="border bg-yellow-500 border-yellow-500 px-4 py-2 text-white text-sm">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($namaDisposisi as $disposisi)
                                    <tr>
                                        <td class="border border-yellow-500 px-4 py-2 text-sm">{{ $disposisi }}</td>
                                        @php $totalPerDisposisi = 0; @endphp
                                        @foreach ($namaBulan as $index => $bulan)
                                            @php
                                                $jumlah = $rekapPerBulan['disposisi_per_pegawai'][$disposisi][$index] ?? 0;
                                                $totalPerDisposisi += $jumlah;
                                            @endphp
                                            <td class="border border-yellow-500 px-4 py-2 text-sm">{{ $jumlah }}</td>
                                        @endforeach
                                        <td class="border border-yellow-500 px-4 py-2 text-sm bg-yellow-200 font-semibold">{{ $totalPerDisposisi }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
            <!-- Rincian Data Kategori Layanan -->
            <div id="layananTable" class=" bg-purple-100 hidden flex flex-col items-center justify-center mt-10 mb-10 mx-52 border-purple-500 rounded-lg shadow-md">
                <div class="mb-10 mt-10">
                    @php
                        $namaBulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                    @endphp
            
                    <!-- Judul Tabel -->
                    <h3 class="text-center text-lg font-semibold mb-5">Rekap Kategori Layanan</h3>
            
                    <!-- Tabel -->
                    <table class="table-auto border-collapse border border-purple-500 w-auto">
                        <thead>
                            <tr>
                                <th class="border bg-purple-500 border-purple-500 px-4 py-2 text-white text-sm">Bulan</th>
                                <th class="border bg-purple-500 border-purple-500 px-4 py-2 text-white text-sm">Total Berbayar</th>
                                <th class="border bg-purple-500 border-purple-500 px-4 py-2 text-white text-sm">Total Nol Rupiah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($namaBulan as $index => $bulan)
                                <tr>
                                    <td class="border border-purple-500 px-4 py-2 text-sm">{{ $bulan }}</td>
                                    <td class="border border-purple-500 px-4 py-2 text-sm">{{ $rekapPerBulan['jenis_layanan_berbayar'][$index] ?? 0 }}</td>
                                    <td class="border border-purple-500 px-4 py-2 text-sm">{{ $rekapPerBulan['jenis_layanan_nol'][$index] ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-semibold">
                                <td class="border border-purple-500 px-4 py-2 text-sm bg-purple-200">Total</td>
                                <td class="border border-purple-500 px-4 py-2 text-sm bg-purple-200">{{ array_sum($rekapPerBulan['jenis_layanan_berbayar']) }}</td>
                                <td class="border border-purple-500 px-4 py-2 text-sm bg-purple-200">{{ array_sum($rekapPerBulan['jenis_layanan_nol']) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <!-- Rincian Data Jenis Layanan -->
            <div id="jenislayananTable" class="bg-orange-100 hidden flex flex-col items-center justify-center mt-10 mb-10 mx-10 border-orange-500 rounded-lg shadow-md">
                <div class="mb-10 mt-10 w-full">
                    @php
                        $namaBulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        $namaLayanan = array_keys($rekapPerBulan['jenis_layanan_nama']); // Ambil nama-nama layanan
                    @endphp

                    <!-- Judul Jenis Layanan -->
                    <h3 class="text-center text-lg font-semibold mb-5">Rekap Jenis Layanan</h3>

                    <!-- Tabel -->
                    <div class="flex justify-center overflow-x-auto">
                        <table class="table-auto border-collapse border border-orange-500 w-auto mx-auto">
                            <thead>
                                <tr>
                                    <th class="border bg-orange-500 border-orange-500 px-4 py-2 text-white text-sm">Nama Layanan</th>
                                    @foreach ($namaBulan as $bulan)
                                        <th class="border bg-orange-500 border-orange-500 px-4 py-2 text-white text-sm">{{ $bulan }}</th>
                                    @endforeach
                                    <th class="border bg-orange-500 border-orange-500 px-4 py-2 text-white text-sm">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($namaLayanan as $layanan)
                                    <tr>
                                        <td class="border border-orange-500 px-4 py-2 text-sm">{{ $layanan }}</td>
                                        @php $totalPerLayanan = 0; @endphp
                                        @foreach ($namaBulan as $index => $bulan)
                                            @php
                                                $jumlah = $rekapPerBulan['jenis_layanan_nama'][$layanan][$index] ?? 0;
                                                $totalPerLayanan += $jumlah;
                                            @endphp
                                            <td class="border border-orange-500 px-4 py-2 text-sm">{{ $jumlah }}</td>
                                        @endforeach
                                        <td class="border border-orange-500 px-4 py-2 text-sm bg-orange-200 font-semibold">{{ $totalPerLayanan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rincian Data Status Permohonan -->
            <div id="statusTable" class="bg-pink-100 hidden flex flex-col items-center justify-center mt-10 mb-10 mx-10 border-pink-500 rounded-lg shadow-md">
                <div class="mb-10 mt-10 w-full">
                    @php
                        $namaBulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        $statusList = [
                            'Diproses' => 'status_diproses',
                            'Selesai Dibuat' => 'status_selesai_dibuat',
                            'Selesai Diambil' => 'status_selesai_diambil',
                            'Batal' => 'status_batal'
                        ];
                    @endphp

                    <!-- Judul Status Permohonan -->
                    <h3 class="text-center text-lg font-semibold mb-5">Rekap Status Permohonan</h3>

                    <!-- Tabel -->
                    <div class="flex justify-center overflow-x-auto">
                        <table class="table-auto border-collapse border border-pink-500 w-auto mx-auto">
                            <thead>
                                <tr>
                                    <th class="border bg-pink-500 border-pink-500 px-4 py-2 text-white text-sm">Status</th>
                                    @foreach ($namaBulan as $bulan)
                                        <th class="border bg-pink-500 border-pink-500 px-4 py-2 text-white text-sm">{{ $bulan }}</th>
                                    @endforeach
                                    <th class="border bg-pink-500 border-pink-500 px-4 py-2 text-white text-sm">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statusList as $statusNama => $statusKey)
                                    <tr>
                                        <td class="border border-pink-500 px-4 py-2 text-sm">{{ $statusNama }}</td>
                                        @php $totalPerStatus = 0; @endphp
                                        @foreach ($namaBulan as $index => $bulan)
                                            @php
                                                $jumlah = $rekapPerBulan[$statusKey][$index] ?? 0;
                                                $totalPerStatus += $jumlah;
                                            @endphp
                                            <td class="border border-pink-500 px-4 py-2 text-sm">{{ $jumlah }}</td>
                                        @endforeach
                                        <td class="border border-pink-500 px-4 py-2 text-sm bg-pink-200 font-semibold">{{ $totalPerStatus }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>


        </div>
    </div>
    
    <script>
        function toggleTable(tableId) {
            const tables = ['permohonan', 'pemohon', 'disposisi', 'layanan', 'jenislayanan', 'status'];
            
            tables.forEach(id => {
                const table = document.getElementById(id + 'Table');
                if (id === tableId) {
                    table.classList.toggle('hidden');
                } else {
                    table.classList.add('hidden');
                }
            });
        }
    </script>
</x-app-layout>
