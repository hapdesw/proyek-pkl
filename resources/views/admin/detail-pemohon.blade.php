<x-app-layout>
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12"> 
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden ml-16 mr-16 flex flex-col">
            <!-- Header dengan judul -->
            <div class="border-b border-gray-200 dark:border-gray-700 p-4 pb-3 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Pemohon
                </h3>
            </div>
            
            <!-- Container untuk data pemohon (kiri) dan filter (kanan) -->
            <div class="p-4 flex justify-between items-start">
                <!-- Data pemohon (kiri) -->
                <div class="w-2/3">
                    <div class="mb-4 text-base"> 
                        <span class="font-medium">Nama Pemohon:</span> {{ $pemohon->nama_pemohon }}
                    </div>
                    
                    @if($pemohon->no_kontak)
                    <div class="mb-4 text-base">
                        <span class="font-medium">No. Kontak:</span> {{ $pemohon->no_kontak }}
                    </div>
                    @endif
                    
                    @if($pemohon->email)
                    <div class="mb-4 text-base">
                        <span class="font-medium">Email:</span> {{ $pemohon->email }}
                    </div>
                    @endif
                    
                    @if($pemohon->instansi)
                    <div class="mb-4 text-base">
                        <span class="font-medium">Instansi:</span> {{ $pemohon->instansi }}
                    </div>
                    @endif

                    <div class="mb-4 text-base">
                        <span class="font-medium">Total Permohonan:</span> {{ array_sum($rekapPerBulan['pemohon']) }} (tahun {{ $tahun }})
                    </div>
                </div>
                
                
                <!-- Filter (kanan) -->
                <div class="w-1/3 flex justify-end">
                    <div class="relative flex items-center">
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
                </div>
                
            </div>
            <div>
                <h2 class="mt-6 mb-8 text-lg font-semibold text-center">
                    Tabel Rekap Detail Pemohon Tahun {{ $tahun }}
                </h2>
               <!-- Rincian Data Pemohon -->
                <div id="pemohonTable" class="bg-teal-100 flex flex-col items-center justify-center mt-10 mb-10 mr-52 ml-52 border-green-500 rounded-lg shadow-md">
                    <div class="mb-10 mt-10">
                        @php
                            $namaBulan = [
                                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ];
                        @endphp
                        <!-- Tabel -->
                        <table class="table-auto  w-80 border-collapse border border-teal-500">
                            <thead>
                                <tr>
                                    <th class="border bg-teal-500 border-green-500 px-4 py-2  text-white text-sm">Bulan</th>
                                    <th class="border bg-teal-500 border-green-500 px-4 py-2 text-white text-sm">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapPerBulan['pemohon'] as $index => $total)
                                    <tr>
                                        <td class="border border-teal-500 px-4 py-2 text-sm">{{ $namaBulan[$index] }}</td>
                                        <td class="border border-teal-500 px-4 py-2 text-sm ">{{ $total }}</td>
                                    </tr>
                                @endforeach
                                <tr class="font-semibold">
                                    <td class="border border-teal-500 px-4 py-2 text-sm">Total</td>
                                    <td class="border border-teal-500 px-4 py-2 text-sm">{{ array_sum($rekapPerBulan['pemohon'] ?? $rekapPerBulan) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButton = document.getElementById('filterButton');
            const dropdownFilters = document.getElementById('dropdownFilters');
            const yearFilter = document.getElementById('yearFilter');
            const applyFilter = document.getElementById('applyFilter');
        
            // dropdown ketika filter button diklik
            filterButton.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownFilters.style.display = dropdownFilters.style.display === 'none' ? 'block' : 'none';
            });
        
            // tutup dropdown ketika klik di luar
            document.addEventListener('click', function(e) {
                if (!dropdownFilters.contains(e.target) && !filterButton.contains(e.target)) {
                    dropdownFilters.style.display = 'none';
                }
            });
        
            // Ketika filter buttondi-klik
            applyFilter.addEventListener('click', function() {
                const selectedYear = yearFilter.value;
                if (selectedYear) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('tahun', selectedYear);
                    window.location.href = url.toString();
                }
                dropdownFilters.style.display = 'none';
            });
        
            // menjaga dropwdown button tetap muncul ketika diklik
            dropdownFilters.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</x-app-layout>