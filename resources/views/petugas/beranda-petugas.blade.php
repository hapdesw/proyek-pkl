<x-app-layout>
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden ml-1 mr-1 flex flex-col min-h-screen">
        <div class="overflow-x-auto min-h-screen">
            <h2 class="text-center mb-10 mt-6 text-lg font-semibold">Rekap Layanan Tahunan</h2>

            <!-- Kotak untuk Total -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 ml-6 mr-6">
                <button id="totalPermohonanBtn" class="p-4 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600" onclick="toggleTable('permohonan')">
                    <p class="text-center">Rekap Total Permohonan</p>
                    <p class="text-center">{{ array_sum($rekapPerBulan['permohonan']) }}</p>
                </button>
                <button id="totalPemohonBtn" class="p-4 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600" onclick="toggleTable('pemohon')">
                    <p class="text-center">Rekap Total Pemohon</p>
                    <p class="text-center">{{ array_sum($rekapPerBulan['pemohon']) }}</p>
                </button>
                <button id="totalDisposisiBtn" class="p-4 bg-yellow-400 text-white rounded-lg shadow-md hover:bg-yellow-500" onclick="toggleTable('disposisi')">
                    <p class="text-center">Rekap Total Disposisi</p>
                    <p class="text-center">{{ array_sum(array_merge(...array_values($rekapPerBulan['disposisi_per_pegawai']))) }}</p>
                </button>
                <button id="totalLayananBtn" class="p-4 bg-purple-500 text-white rounded-lg shadow-md hover:bg-purple-600" onclick="toggleTable('layanan')">
                    <p class="text-center">Rekap Total Layanan</p>
                    <p class="text-center">{{ array_sum($rekapPerBulan['jenis_layanan_berbayar']) + array_sum($rekapPerBulan['jenis_layanan_nol']) }}</p>
                </button>
                <button id="jenisLayananBtn" class="p-4 bg-orange-500 text-white rounded-lg shadow-md hover:bg-orange-600" onclick="toggleTable('jenislayanan')">
                    <p class="text-center">Rekap Jenis Layanan</p>
                    <p class="text-center">{{ array_sum(array_merge(...array_values($rekapPerBulan['jenis_layanan_nama']))) }}</p>
                </button>
                <button id="statusBtn" class="p-4 bg-pink-500 text-white rounded-lg shadow-md hover:bg-pink-600" onclick="toggleTable('status')">
                    <p class="text-center">Rekap Status Permohonan</p>
                    <p class="text-center">{{ array_sum($rekapPerBulan['jenis_layanan_berbayar']) + array_sum($rekapPerBulan['jenis_layanan_nol']) }}</p>
                </button>
            </div>

            <!-- Rincian Data (Tabel) -->
            <div id="permohonanTable" class="hidden">
                <table class="table table-bordered table-striped">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Komponen</th>
                            <th scope="col" class="px-4 py-3">Januari</th>
                            <th scope="col" class="px-4 py-3">Februari</th>
                            <th scope="col" class="px-4 py-3">Maret</th>
                            <th scope="col" class="px-4 py-3">April</th>
                            <th scope="col" class="px-4 py-3">Mei</th>
                            <th scope="col" class="px-4 py-3">Juni</th>
                            <th scope="col" class="px-4 py-3">Juli</th>
                            <th scope="col" class="px-4 py-3">Agustus</th>
                            <th scope="col" class="px-4 py-3">September</th>
                            <th scope="col" class="px-4 py-3">Oktober</th>
                            <th scope="col" class="px-4 py-3">November</th>
                            <th scope="col" class="px-4 py-3">Desember</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Permohonan</td>
                            @foreach($rekapPerBulan['permohonan'] as $bulan)
                                <td>{{ $bulan }}</td>
                            @endforeach
                            {{-- <td>{{ array_sum($rekapPerBulan['permohonan']) }}</td> --}}
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="pemohonTable" class="hidden">
                <table class="table table-bordered table-striped">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Komponen</th>
                            <th scope="col" class="px-4 py-3">Januari</th>
                            <th scope="col" class="px-4 py-3">Februari</th>
                            <th scope="col" class="px-4 py-3">Maret</th>
                            <th scope="col" class="px-4 py-3">April</th>
                            <th scope="col" class="px-4 py-3">Mei</th>
                            <th scope="col" class="px-4 py-3">Juni</th>
                            <th scope="col" class="px-4 py-3">Juli</th>
                            <th scope="col" class="px-4 py-3">Agustus</th>
                            <th scope="col" class="px-4 py-3">September</th>
                            <th scope="col" class="px-4 py-3">Oktober</th>
                            <th scope="col" class="px-4 py-3">November</th>
                            <th scope="col" class="px-4 py-3">Desember</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Pemohon</td>
                            @foreach($rekapPerBulan['pemohon'] as $bulan)
                                <td>{{ $bulan }}</td>
                            @endforeach
                            
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="disposisiTable" class="hidden">
                <table class="table table-bordered table-striped">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Komponen</th>
                            <th scope="col" class="px-4 py-3">Januari</th>
                            <th scope="col" class="px-4 py-3">Februari</th>
                            <th scope="col" class="px-4 py-3">Maret</th>
                            <th scope="col" class="px-4 py-3">April</th>
                            <th scope="col" class="px-4 py-3">Mei</th>
                            <th scope="col" class="px-4 py-3">Juni</th>
                            <th scope="col" class="px-4 py-3">Juli</th>
                            <th scope="col" class="px-4 py-3">Agustus</th>
                            <th scope="col" class="px-4 py-3">September</th>
                            <th scope="col" class="px-4 py-3">Oktober</th>
                            <th scope="col" class="px-4 py-3">November</th>
                            <th scope="col" class="px-4 py-3">Desember</th>
                            <th scope="col" class="px-4 py-3">Total</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapPerBulan['disposisi_per_pegawai'] as $pegawai => $disposisi)
                            <tr>
                                <td>{{ $pegawai }}</td>
                                @foreach($disposisi as $bulan)
                                    <td>{{ $bulan }}</td>
                                @endforeach
                                <td>{{ array_sum($disposisi) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="layananTable" class="hidden">
                <table class="table table-bordered table-striped">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Komponen</th>
                            <th scope="col" class="px-4 py-3">Januari</th>
                            <th scope="col" class="px-4 py-3">Februari</th>
                            <th scope="col" class="px-4 py-3">Maret</th>
                            <th scope="col" class="px-4 py-3">April</th>
                            <th scope="col" class="px-4 py-3">Mei</th>
                            <th scope="col" class="px-4 py-3">Juni</th>
                            <th scope="col" class="px-4 py-3">Juli</th>
                            <th scope="col" class="px-4 py-3">Agustus</th>
                            <th scope="col" class="px-4 py-3">September</th>
                            <th scope="col" class="px-4 py-3">Oktober</th>
                            <th scope="col" class="px-4 py-3">November</th>
                            <th scope="col" class="px-4 py-3">Desember</th>
                            <th scope="col" class="px-4 py-3">Total</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Layanan Berbayar</td>
                            @foreach($rekapPerBulan['jenis_layanan_berbayar'] as $bulan)
                                <td>{{ $bulan }}</td>
                            @endforeach
                            <td>{{ array_sum($rekapPerBulan['jenis_layanan_berbayar']) }}</td>
                        </tr>
                        <tr>
                            <td>Layanan Nolrupiah</td>
                            @foreach($rekapPerBulan['jenis_layanan_nol'] as $bulan)
                                <td>{{ $bulan }}</td>
                            @endforeach
                            <td>{{ array_sum($rekapPerBulan['jenis_layanan_nol']) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="jenislayananTable" class="hidden">
                <table class="table table-bordered table-striped">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Komponen</th>
                            <th scope="col" class="px-4 py-3">Januari</th>
                            <th scope="col" class="px-4 py-3">Februari</th>
                            <th scope="col" class="px-4 py-3">Maret</th>
                            <th scope="col" class="px-4 py-3">April</th>
                            <th scope="col" class="px-4 py-3">Mei</th>
                            <th scope="col" class="px-4 py-3">Juni</th>
                            <th scope="col" class="px-4 py-3">Juli</th>
                            <th scope="col" class="px-4 py-3">Agustus</th>
                            <th scope="col" class="px-4 py-3">September</th>
                            <th scope="col" class="px-4 py-3">Oktober</th>
                            <th scope="col" class="px-4 py-3">November</th>
                            <th scope="col" class="px-4 py-3">Desember</th>
                            <th scope="col" class="px-4 py-3">Total</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapPerBulan['jenis_layanan_nama'] as $layanan => $permohonan)
                            <tr>
                                <td>{{ $layanan }}</td>
                                @foreach($permohonan as $bulan)
                                    <td>{{ $bulan }}</td>
                                @endforeach
                                <td>{{ array_sum($permohonan) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="statusTable" class="hidden">
                <table class="table table-bordered table-striped">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Komponen</th>
                            <th scope="col" class="px-4 py-3">Januari</th>
                            <th scope="col" class="px-4 py-3">Februari</th>
                            <th scope="col" class="px-4 py-3">Maret</th>
                            <th scope="col" class="px-4 py-3">April</th>
                            <th scope="col" class="px-4 py-3">Mei</th>
                            <th scope="col" class="px-4 py-3">Juni</th>
                            <th scope="col" class="px-4 py-3">Juli</th>
                            <th scope="col" class="px-4 py-3">Agustus</th>
                            <th scope="col" class="px-4 py-3">September</th>
                            <th scope="col" class="px-4 py-3">Oktober</th>
                            <th scope="col" class="px-4 py-3">November</th>
                            <th scope="col" class="px-4 py-3">Desember</th>
                            <th scope="col" class="px-4 py-3">Total</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Diproses</td>
                            @foreach($rekapPerBulan['jenis_layanan_berbayar'] as $bulan)
                                <td>{{ $bulan }}</td>
                            @endforeach
                            <td>{{ array_sum($rekapPerBulan['jenis_layanan_berbayar']) }}</td>
                        </tr>
                        <tr>
                            <td>Selesai Dibuat</td>
                            @foreach($rekapPerBulan['jenis_layanan_nol'] as $bulan)
                                <td>{{ $bulan }}</td>
                            @endforeach
                            <td>{{ array_sum($rekapPerBulan['jenis_layanan_nol']) }}</td>
                        </tr>
                        <tr>
                            <td>Selesai Diambil</td>
                            @foreach($rekapPerBulan['jenis_layanan_nol'] as $bulan)
                                <td>{{ $bulan }}</td>
                            @endforeach
                            <td>{{ array_sum($rekapPerBulan['jenis_layanan_nol']) }}</td>
                        </tr>
                        <tr>
                            <td>Batal</td>
                            @foreach($rekapPerBulan['jenis_layanan_nol'] as $bulan)
                                <td>{{ $bulan }}</td>
                            @endforeach
                            <td>{{ array_sum($rekapPerBulan['jenis_layanan_nol']) }}</td>
                        </tr>
                    </tbody>
                </table>
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
