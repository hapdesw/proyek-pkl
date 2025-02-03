<x-app-layout>
        <div class="mx-auto max-w-screen-xl px-4 lg:px-2"> 
            
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

                @if (Session::has('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: '{{ Session::get('error') }}',
                        });
                    </script>
                @endif
               

                <div class="border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white p-4 pb-3">
                        Permohonan
                    </h3>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                            </div>
                        </form>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">                  
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                Pilih Bulan
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            {{-- <div id="actionsDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Pilih Bulan</h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="actionsDropdownButton">
                                    <li class="flex items-center">
                                        <input id="januari" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="januari" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Januari</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="februari" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="februari" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Februari</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="maret" type="checkbox"  class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="maret" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Maret</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="april" type="checkbox"  class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="april" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">April</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="mei" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="mei" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Mei</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="juni" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="juni" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Juni</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="juli" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="juli" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Juli</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="agustus" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="agustus" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Agustus</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="september" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="september" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">September</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="oktober" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="oktober" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Oktober</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="november" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="november" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">November</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="desember" type="checkbox" class="month-filter w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="desember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Desember</label>
                                    </li>
                                </ul>
                            </div> --}}
                             <!-- Dropdown Filter Bulan -->
                            <div class="mb-3">
                                
                                <div id="actionsDropdown" class="hidden p-3 bg-white shadow rounded-lg">
                                    <h6 class="mb-3">Pilih Bulan</h6>
                                    <ul class="list-unstyled">
                                        @php
                                            $months = [
                                                'januari', 'februari', 'maret', 'april', 'mei', 'juni',
                                                'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
                                            ];
                                        @endphp
                                        @foreach ($months as $month)
                                            <li class="form-check">
                                                <input id="{{ $month }}" type="checkbox" class="month-filter form-check-input">
                                                <label for="{{ $month }}" class="form-check-label">{{ ucfirst($month) }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- JavaScript -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    document.querySelectorAll('.month-filter').forEach(checkbox => {
                                        checkbox.addEventListener('change', function () {
                                            const selectedMonths = getSelectedMonths();
                                            applyFilter(selectedMonths);
                                        });
                                    });

                                    function getSelectedMonths() {
                                        const selectedMonths = [];
                                        document.querySelectorAll('.month-filter:checked').forEach(checkbox => {
                                            selectedMonths.push(checkbox.id);
                                        });
                                        return selectedMonths;
                                    }

                                    function applyFilter(selectedMonths) {
                                        if (selectedMonths.length > 0) {
                                            filterPermohonanByMonth(selectedMonths);
                                        } else {
                                            fetchAllPermohonan();
                                        }
                                    }

                                    function filterPermohonanByMonth(months) {
                                        fetch(`/permohonan/filter?months=${months.join(',')}`)
                                            .then(response => response.json())
                                            .then(data => {
                                                displayPermohonan(data);
                                            })
                                            .catch(error => console.error('Error:', error));
                                    }

                                    function fetchAllPermohonan() {
                                        fetch('/petugas-layanan/permohonan')
                                            .then(response => response.json())
                                            .then(data => {
                                                displayPermohonan(data);
                                            });
                                    }

                                    function displayPermohonan(data) {
                                        let tableBody = document.getElementById('table-body');
                                        tableBody.innerHTML = '';
                                        data.forEach(permohonan => {
                                            let row = `<tr>
                                                <td>${permohonan.id}</td>
                                                <td>${permohonan.tanggal_diajukan}</td>
                                                <td>${permohonan.kategori}</td>
                                                
                                                <td>${permohonan.deskripsi_keperluan}</td>
                                                <td>${permohonan.status_permohonan}</td>
                                            </tr>`;
                                            tableBody.innerHTML += row;
                                        });
                                    }
                                });
                            </script>
                   
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                Pilih Tahun
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                <svg class="h-3.5 w-3.5 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
                                </svg>                               
                                Export
                            </button>
                            <div>
                                <a href="{{ route('petugas.permohonan.create') }}">
                                    <button class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none dark:focus:ring-primary-800">
                                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                        </svg>
                                        Ajukan Permohonan
                                    </button> 
                                </a>    
                            </div>            
                        </div>
                    </div>
                </div>
                {{-- Tabel --}}
                <div class="overflow-x-auto  min-h-screen">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">No.</th>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-4 py-3">Tanggal Pengajuan</th>
                                <th scope="col" class="px-4 py-3">Kategori</th>
                                <th scope="col" class="px-4 py-3">Layanan</th>
                                <th scope="col" class="px-4 py-3">Pemohon</th>
                                <th scope="col" class="px-4 py-3">Keperluan</th>
                                <th scope="col" class="px-4 py-3">Disposisi</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3">Aksi</th> 
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @forelse ($permohonan as $pm)

                                <tr class="border-b dark:border-gray-700 text-darkKnight">
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $pm->id }}</td>
                                    <td class="px-3 py-3 w-20">{{ \Carbon\Carbon::parse($pm->tanggal_diajukan)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">{{ $pm->kategori_berbayar == 'Nolrupiah' ? 'Nol Rupiah' : $pm->kategori_berbayar }}</td>
                                    <td class="px-4 py-3">{{ $pm->jenisLayanan->nama_jenis_layanan}}</td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <strong>{{ $pm->pemohon->nama_pemohon }}</strong> <!-- Nama pemohon -->
                                        </div>
                                       
                                        @if(!empty($pm->pemohon->no_kontak))
                                            <div>
                                                {{ $pm->pemohon->no_kontak }} <!-- No. HP pemohon jika tersedia -->
                                            </div>
                                        @endif
                                        
                                        <div>
                                            {{ $pm->pemohon->instansi }} <!-- Tetap menampilkan instansi -->
                                        </div>
                                    </td>
                                    
                                    <td class="px-4 py-3">{{ $pm->deskripsi_keperluan }}</td>
                                    <td class="px-4 py-3 w-32">
                                        @if($pm->disposisi)
                                            @php
                                                $pegawaiList = collect([
                                                    optional($pm->disposisi->pegawai1)->nama,
                                                    optional($pm->disposisi->pegawai2)->nama,
                                                    optional($pm->disposisi->pegawai3)->nama,
                                                ])->filter(); 
                                            @endphp

                                            @if ($pegawaiList->count() === 1)
                                                {{ $pegawaiList->first() }}
                                            @elseif ($pegawaiList->count() > 1)
                                                <ul>
                                                    @foreach ($pegawaiList as $pegawai)
                                                        <li>• {{ $pegawai }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @else
                                            <span class="text-redNew !important">Belum diatur</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-2 py-2">
                                        @if($pm->status_permohonan === 'Diproses')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300 inline-block">{{ $pm->status_permohonan }}</span>
                                        @elseif($pm->status_permohonan === 'Selesai Dibuat')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400 inline-block">{{ $pm->status_permohonan }}</span>
                                        @elseif($pm->status_permohonan === 'Selesai Diambil')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400 inline-block">{{ $pm->status_permohonan }}</span>
                                        @elseif($pm->status_permohonan === 'Batal')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400 inline-block">{{ $pm->status_permohonan }}</span>
                                        @endif
                                    </td>
                                    
                                    
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button id="actions-dropdown-button-{{ $pm->id }}" data-dropdown-toggle="actions-dropdown-{{ $pm->id }}" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="actions-dropdown-{{ $pm->id }}" class="hidden z-10 w-auto bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actions-dropdown-button-{{ $pm->id }}">
                                                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-start hover:bg-gray-100 md:space-x-3 flex-shrink-0">                  
                                                    <div class="flex items-center space-x-3 w-auto md:w-auto">
                                                        <div x-data="{ open: false }" class="block px-2">
                                                            <button data-modal-target="add-modal"  data-modal-toggle="add-modal" class="flex items-center gap-6 px-2 py-2 text-sm" onclick="showDetail({{ $pm->id }})">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m4 8h6m-6-4h6m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z"/>
                                                                </svg>
                                                                Detail Permohonan
                                                            </button>     
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <li class="flex items-center px-4 py-1" >
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                        </svg>
                                                                                            
                                                        <a href="{{ route('petugas.permohonan.edit', $pm->id) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit Permohonan</a>
                                                    </li>
                                                </div>
                                               
                                                <div class="block px-0 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <li class=" flex items-center px-2 py-1">
                                                        <form id="delete-form-{{$pm->id}}" action="{{ route('petugas.permohonan.destroy', $pm->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" onclick="confirmDelete({{$pm->id}})" class="flex items-center gap-6 py-2 px-3 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                                <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                                </svg>
                                                               Hapus Permohonan
                                                            </button>
                                                        </form>
                                                    </li>   
                                                     {{-- Pop up dialog untuk hapus --}}
                                                    <script>
                                                        function confirmDelete(id) {
                                                            Swal.fire({
                                                                title: 'Apakah Anda yakin?',
                                                                text: "Data permohonan dengan ID {{$pm->id}} akan dihapus secara permanen!",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: 'Ya, hapus!',
                                                                cancelButtonText: 'Batal'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    document.getElementById('delete-form-' + id).submit();
                                                                }
                                                            });
                                                        }
                                                        </script>   
                                                </div>   
                                                
                                                <div class="block px-0 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <li class=" flex items-center px-2 py-1">
                                                        <button onclick="updateStatus({{ $pm->id }}, 'Batal')" class="flex items-center gap-6 py-2 px-3 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 9H8a5 5 0 0 0 0 10h9m4-10-4-4m4 4-4 4"/>
                                                            </svg>
                                                            Batalkan Permohonan
                                                        </button>
                                                     
                                                    </li>   
                                                </div>     
                                            </ul>
                                        </div>   
                                         {{-- Modal untuk detail permohonan --}}
                                        <div id="add-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <button onclick="showDetail({{ $pm->id }})"></button>
                                            <!-- Simpan data dalam atribut data- -->
                                            @php
                                                $tanggalSelesai = $pm->tanggal_selesai;
                                                $tanggalDiambil = $pm->tanggal_diambil;
                                            @endphp
                                            <div id="permohonan-{{ $pm->id }}" class="hidden"
                                                data-id="{{ $pm->id }}"
                                                data-tgl-diajukan="{{ $pm->tanggal_diajukan }}"
                                                data-kategori="{{ $pm->kategori_berbayar }}"
                                                data-jenis-layanan="{{ $pm->jenisLayanan->nama_jenis_layanan ?? 'Tidak Diketahui' }}"
                                                data-deskripsi="{{ $pm->deskripsi_keperluan }}"
                                                data-disposisi1="{{$pm->disposisi->pegawai1->nama ?? 'Belum diatur' }}"
                                                data-disposisi2="{{ $pm->disposisi->pegawai2->nama ?? 'Belum diatur' }}"
                                                data-disposisi3="{{ $pm->disposisi->pegawai3->nama ?? 'Belum diatur' }}"
                                                data-tgl-disposisi="{{ $pm->disposisi->tanggal_disposisi ?? 'Belum Diatur' }}"
                                                data-pemohon="{{ $pm->pemohon->nama_pemohon ?? 'Tidak Diketahui' }}"
                                                data-instansi="{{ $pm->pemohon->instansi ?? 'Tidak Diketahui' }}"
                                                data-hp="{{ $pm->pemohon->no_kontak ?? 'Tidak Ada' }}"
                                                data-email="{{ $pm->pemohon->email ?? 'Tidak Ada' }}"
                                                data-tgl-selesai="{{ $tanggalSelesai ?? 'Belum Diatur' }}"
                                                data-tgl-diambil="{{ $tanggalDiambil ?? 'Belum Diatur' }}"
                                                data-status="{{ $pm->status_permohonan }}">
                                            </div>
                                           
                                                {{-- <div class="relative bg-yellow-400 w-auto h-auto max-w-screen-xl mx-auto"> --}}
                                                    <div class="relative bg-white p-5 mt-10 w-full max-h-fit max-w-fit rounded-lg shadow-lg">
                                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400" data-modal-toggle="add-modal">✖</button>
                                                        <div class="border-b border-gray-200 dark:border-gray-700">
                                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white p-4 pb-3">
                                                                Detail Permohonan
                                                            </h3>
                                                        </div>
                                                       
                                                        <!-- ID Permohonan-->
                                                        <p class="mb-2"><strong>ID Permohonan:</strong> <span id="detail-id"></span></p>
                                                        <p class="mb-2"><strong>Tanggal Diajukan:</strong> <span id="detail-tgl-diajukan"></span></p>
                                                        <p class="mb-2"><strong>Kategori Layanan:</strong> <span id="detail-kategori"></span></p>
                                                        <p class="mb-2"><strong>Jenis Layanan:</strong> <span id="detail-jenis-layanan"></span></p>
                                                        <p class="mb-2"><strong>Deskripsi Keperluan:</strong> <span id="detail-deskripsi"></span></p>
                                                        <p class="mb-2"><strong>Disposisi 1:</strong> <span id="detail-disposisi1"></span></p>
                                                        <p class="mb-2"><strong>Disposisi 2:</strong> <span id="detail-disposisi2"></span></p>
                                                        <p class="mb-2"><strong>Disposisi 3:</strong> <span id="detail-disposisi3"></span></p>
                                                        <p class="mb-2"><strong>Tanggal Disposisi:</strong> <span id="detail-tgl-disposisi"></span></p>
                                                        <p class="mb-2"><strong>Pemohon:</strong> <span id="detail-pemohon"></span></p>
                                                        <p class="mb-2"><strong>Instansi:</strong> <span id="detail-instansi"></span></p>
                                                        <p class="mb-2"><strong>No HP:</strong> <span id="detail-hp"></span></p>
                                                        <p class="mb-2"><strong>Email:</strong> <span id="detail-email"></span></p>
                                                        <p class="mb-2"><strong>Tanggal Selesai:</strong> <span id="detail-tgl-selesai"></span>
                                                        <p class="mb-2"><strong>Tanggal Diambil:</strong> <span id="detail-tgl-diambil"></span>
                                                        <p class="mb-2"><strong>Status Permohonan:</strong> <span id="detail-status"></span></p>
                                                      
                                                    </div>
                                                {{-- </div>  --}}
                                            </div>
                                        </div> 
                                        <script>
                                           
                                            function showDetail(id) {
                                                // Ambil data dari elemen dengan ID sesuai
                                                const permohonan = document.getElementById('permohonan-' + id);
                                                if (!permohonan) {
                                                    console.error('Data permohonan tidak ditemukan untuk ID:', id);
                                                    return;
                                                }
                                                document.getElementById('detail-id').textContent = permohonan.getAttribute('data-id');
                                                document.getElementById('detail-tgl-diajukan').textContent = permohonan.getAttribute('data-tgl-diajukan');
                                                document.getElementById('detail-kategori').textContent = permohonan.getAttribute('data-kategori');
                                                document.getElementById('detail-jenis-layanan').textContent = permohonan.getAttribute('data-jenis-layanan');
                                                document.getElementById('detail-deskripsi').textContent = permohonan.getAttribute('data-deskripsi');
                                                document.getElementById('detail-disposisi1').textContent = permohonan.getAttribute('data-disposisi1');
                                                document.getElementById('detail-disposisi2').textContent = permohonan.getAttribute('data-disposisi2');
                                                document.getElementById('detail-disposisi3').textContent = permohonan.getAttribute('data-disposisi3');
                                                document.getElementById('detail-tgl-disposisi').textContent = permohonan.getAttribute('data-tgl-disposisi');
                                                document.getElementById('detail-pemohon').textContent = permohonan.getAttribute('data-pemohon');
                                                document.getElementById('detail-instansi').textContent = permohonan.getAttribute('data-instansi');
                                                document.getElementById('detail-hp').textContent = permohonan.getAttribute('data-hp');
                                                document.getElementById('detail-email').textContent = permohonan.getAttribute('data-email');
                                                document.getElementById('detail-tgl-selesai').textContent = permohonan.getAttribute('data-tgl-selesai');
                                                document.getElementById('detail-tgl-diambil').textContent = permohonan.getAttribute('data-tgl-diambil');
                                                document.getElementById('detail-status').textContent = permohonan.getAttribute('data-status');
                                                
                                                // Tampilkan modal
                                                document.getElementById('add-modal').classList.remove('hidden');
                                               
                                            }
                                            
                                      
                                            function updateStatus(id, status) {
                                                Swal.fire({
                                                    title: "Memproses...",
                                                    text: "Mohon tunggu sebentar",
                                                    icon: "info",
                                                    allowOutsideClick: false,
                                                    showConfirmButton: false,
                                                    didOpen: () => {
                                                        Swal.showLoading();
                                                    }
                                                });

                                                fetch(`/petugas-layanan/permohonan/update-status/${id}`, {
                                                    method: "POST",
                                                    headers: {
                                                        "Content-Type": "application/json",
                                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                                                    },
                                                    body: JSON.stringify({ status: status })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    Swal.close(); // Tutup loading setelah mendapatkan respons dari server
                                                    if (data.success) {
                                                        Swal.fire({
                                                            title: "Berhasil!",
                                                            text: "Status permohonan berhasil diperbarui!",
                                                            icon: "success",
                                                            confirmButtonText: "OK"
                                                        }).then(() => {
                                                            location.reload(); // Refresh halaman setelah klik OK
                                                        });
                                                    } else {
                                                        Swal.fire({
                                                            title: "Gagal!",
                                                            text: "Gagal memperbarui status: " + data.message,
                                                            icon: "error",
                                                            confirmButtonText: "Coba Lagi"
                                                        });
                                                    }
                                                })
                                                .catch(error => {
                                                    Swal.close();
                                                    Swal.fire({
                                                        title: "Error!",
                                                        text: "Terjadi kesalahan: " + error.message,
                                                        icon: "error",
                                                        confirmButtonText: "OK"
                                                    });
                                                });
                                            }

                                        </script>      
                                    </td>
                                </tr> 
                            @empty
                            <tr>
                                <td colspan="10" class="text-center align-middle h-20">Tidak ada permohonan</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col  md:flex-row  justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div> 
</x-app-layout>
