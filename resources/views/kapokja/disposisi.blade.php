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
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white p-4 pb-3">
                        Disposisi
                    </h1>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/3">
                        <form action="{{ route('kapokja.disposisi') }}" method="GET" class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    id="simple-search" 
                                    name="search" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                                    placeholder="Search" 
                                    value="{{ request('search') }}" 
                                >
                            </div>
                        </form>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">                  
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <div class="relative inline-block">
                                <!-- Tombol Filter -->
                                <button id="filterButton" data-dropdown-toggle="dropdownFilters" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <svg class="h-3.5 w-3.5 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
                                    </svg>                                      
                                    Filter
                                </button>
                                <!-- Dropdown Filter -->
                                <div id="dropdownFilters" style="display: none;" class="absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-md p-4">
                                    <h3 class="font-semibold mb-2">Pilih Bulan</h3>
                                    <div class="grid grid-cols-2 gap-2">
                                        @php
                                            $months = [
                                                'Januari', 'Juli', 'Februari', 'Agustus', 'Maret', 'September', 'April', 'Oktober', 'Mei', 'November', 'Juni', 'Desember'
                                            ];
                                        @endphp
                                        @foreach ($months as $month)
                                            <label class="flex items-center space-x-2">
                                                <input type="checkbox" class="month-filter" value="{{ strtolower($month) }}">
                                                <span>{{ $month }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                            
                                    <!-- Pilih Tahun -->
                                    <h3 class="font-semibold mt-4 mb-2">Pilih Tahun</h3>
                                    <select id="yearFilter" class="w-full p-2 border rounded">
                                        <option value="">Semua Tahun</option>
                                    </select>

                                    <!-- Filter Disposisi -->
                                    <h3 class="font-semibold mt-4 mb-2">Status Disposisi</h3>
                                    <select id="disposisiFilter" class="w-full p-2 border rounded">
                                        <option value="">Semua</option>
                                        <option value="sudah">Sudah Disposisi</option>
                                        <option value="belum">Belum Disposisi</option>
                                    </select>
                            
                                    <!-- Tombol Terapkan -->
                                    <button id="applyFilter" class="mt-4 w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">
                                        Terapkan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const filterButton = document.getElementById('filterButton');
                            const filterDropdown = document.getElementById('dropdownFilters');
                            const applyFilterButton = document.getElementById('applyFilter');
                            const monthCheckboxes = document.querySelectorAll('.month-filter');
                            const yearSelect = document.getElementById('yearFilter');
                            const disposisiSelect = document.getElementById('disposisiFilter');

                            filterButton.addEventListener('click', function () {
                                filterDropdown.style.display = (filterDropdown.style.display === 'none') ? 'block' : 'none';
                            });

                            document.addEventListener('click', function (event) {
                                if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                                    filterDropdown.style.display = 'none';
                                }
                            });

                            fetch('/kapokja/disposisi/available-years')
                                .then(response => response.json())
                                .then(years => {
                                    yearSelect.innerHTML = '<option value="">Semua Tahun</option>';

                                    years.forEach(year => {
                                        const option = document.createElement('option');
                                        option.value = year;
                                        option.textContent = year;
                                        yearSelect.appendChild(option);
                                    });
                                })
                                .catch(error => console.error('Error fetching years:', error));

                            applyFilterButton.addEventListener('click', function () {
                                const selectedMonths = Array.from(monthCheckboxes)
                                    .filter(checkbox => checkbox.checked)
                                    .map(checkbox => checkbox.value);
                                const selectedYear = yearSelect.value;
                                const selectedDisposisi = disposisiSelect.value;

                                // Buat URL dengan parameter filter
                                const url = new URL(window.location.href);

                                // Hanya tambahkan parameter `months` jika ada bulan yang dipilih
                                if (selectedMonths.length > 0) {
                                    url.searchParams.set('months', selectedMonths.join(','));
                                } else {
                                    url.searchParams.delete('months'); 
                                }

                                // Hanya tambahkan parameter `year` jika tahun dipilih
                                if (selectedYear) {
                                    url.searchParams.set('year', selectedYear);
                                } else {
                                    url.searchParams.delete('year'); 
                                }

                                // Hanya tambahkan parameter `disposisi` jika status disposisi dipilih
                                if (selectedDisposisi) {
                                    url.searchParams.set('disposisi', selectedDisposisi);
                                } else {
                                    url.searchParams.delete('disposisi');
                                }

                                // Redirect ke URL dengan parameter filter
                                window.location.href = url.toString();
                            });
                        });
                        </script>
                    </div>
                </div>
                {{-- Tabel --}}
                <div class="overflow-x-auto  min-h-screen">
                    <table class="w-full text-sm text-left ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                            <tr>
                                <th scope="col" class="px-3 py-3">No.</th>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-3 py-3">Tanggal Pengajuan</th>
                                <th scope="col" class="px-1.5 py-3">Kategori</th>
                                <th scope="col" class="px-2.5 py-3">Layanan</th>
                                <th scope="col" class="px-3 py-3 w-36">Pemohon</th>
                                <th scope="col" class="px-3 py-3">Keperluan</th>
                                <th scope="col" class="px-4 py-3 w-32">Disposisi</th>
                                <th scope="col" class="px-3 py-3">Tanggal Disposisi</th>
                                <th scope="col" class="px-2 py-2">Status</th>
                                <th scope="col" class="px-3 py-3">Aksi</th> 
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @forelse ($permohonan as $pm)

                                <tr class="border-b dark:border-gray-700 text-darkKnight">
                                    <td class="px-3 py-3">{{ ($permohonan->currentPage() - 1) * $permohonan->perPage() + $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $pm->id }}</td>
                                    <td class="px-3 py-3 w-20">{{ \Carbon\Carbon::parse($pm->tanggal_diajukan)->format('d/m/Y') }}</td>
                                    <td class="px-1.5 py-3">{{ $pm->kategori_berbayar == 'Nolrupiah' ? 'Nol Rupiah' : $pm->kategori_berbayar }}</td>
                                    <td class="px-2.5 py-3">{{ $pm->jenisLayanan->nama_jenis_layanan}}</td>
                                    <td class="px-3 py-3 w-36">
                                        <div>
                                            <strong>{{ $pm->pemohon->nama_pemohon }}</strong>
                                        </div>
                                        @if(!empty($pm->pemohon->no_kontak))
                                            <div>
                                                {{ $pm->pemohon->no_kontak }}
                                            </div>
                                        @endif
                                        <div>
                                            {{ $pm->pemohon->instansi }}
                                        </div>
                                    </td> 
                                    <td class="px-3 py-3">{{ $pm->deskripsi_keperluan }}</td>
                                    <td class="px-4 py-3 w-32">
                                        @if($pm->disposisi)
                                            @php
                                                $pegawaiList = collect([
                                                    optional($pm->disposisi->pegawai1)->nama,
                                                    optional($pm->disposisi->pegawai2)->nama,
                                                    optional($pm->disposisi->pegawai3)->nama,
                                                    optional($pm->disposisi->pegawai4)->nama,
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
                                    <td class="px-3 py-3">
                                        @if($pm->disposisi?->tanggal_disposisi)
                                            {{ \Carbon\Carbon::parse($pm->disposisi->tanggal_disposisi)->format('d/m/Y') }}
                                        @else
                                            <span class="text-redNew !important">Belum diatur</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2">
                                        @if($pm->status_permohonan === 'Diproses')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded border border-yellow-300 inline-block">{{ $pm->status_permohonan }}</span>
                                        @elseif($pm->status_permohonan === 'Selesai Dibuat')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded border border-blue-400 inline-block">{{ $pm->status_permohonan }}</span>
                                        @elseif($pm->status_permohonan === 'Selesai Diambil')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded border border-green-400 inline-block">{{ $pm->status_permohonan }}</span>
                                        @elseif($pm->status_permohonan === 'Batal')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded border border-red-400 inline-block">{{ $pm->status_permohonan }}</span>
                                        @endif
                                    </td>                               
                                    
                                    <td class="px-3 py-3 flex items-center">
                                        <button id="actions-dropdown-button-{{ $pm->id }}" data-dropdown-toggle="actions-dropdown-{{ $pm->id }}" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="actions-dropdown-{{ $pm->id }}" class="hidden z-10 w-auto bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actions-dropdown-button-{{ $pm->id }}">
                                                <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <div x-data="{ open: false }" class="block px-2">
                                                        <button data-modal-target="add-modal"  data-modal-toggle="add-modal" class="flex items-center gap-4 px-2 py-2 text-sm" onclick="showDetail({{ $pm->id }})">
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m4 8h6m-6-4h6m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z"/>
                                                            </svg>
                                                            Detail Permohonan
                                                        </button>     
                                                    </div>
                                                </div>
                                                @if(isset($pm->disposisi) && ($pm->disposisi->pegawai1 || $pm->disposisi->pegawai2 || $pm->disposisi->pegawai3 || $pm->disposisi->pegawai4))
                                                    <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        <li class=" flex items-center px-4 py-1">
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                            </svg>
                                                            <a href="{{ route('kapokja.disposisi.edit', ['id' => $pm->id]) }}" 
                                                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Edit Disposisi
                                                            </a>
                                                        </li>
                                                    </div>

                                                    <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        <li class="flex items-center px-4 py-1">
                                                            <form id="delete-form-{{ $pm->id }}" 
                                                                action="{{ route('kapokja.disposisi.destroy', $pm->id) }}" 
                                                                method="POST" 
                                                                class="flex items-center">
                                                                @csrf
                                                                @method('DELETE')
                                                                
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                                </svg>
                                                                
                                                                <button type="button" 
                                                                        onclick="confirmDelete({{ $pm->id }})" 
                                                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                                    Hapus Disposisi
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </div>
                                                @else
                                                    <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        <li class="flex items-center px-4 py-1">
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                            </svg>
                                                            <a href="{{ route('kapokja.disposisi.create', ['id' => $pm->id]) }}" 
                                                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            Atur Disposisi
                                                            </a>
                                                        </li>
                                                    </div>
                                                @endif
                                            </ul>
                                        </div>
                                        <script>
                                            function confirmDelete(id) {
                                                Swal.fire({
                                                    title: 'Apakah Anda yakin?',
                                                    text: "Data disposisi akan dihapus secara permanen!",
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
                                         {{-- Modal untuk detail permohonan --}}
                                         <div id="add-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <button onclick="showDetail({{ $pm->id }})"></button>
                                            <!-- Simpan data dalam atribut data- -->
                                            @php
                                                $tanggalDiajukan = \Carbon\Carbon::parse($pm->tanggal_diajukan)->format('d/m/Y');
                                                $tanggalSelesai = $pm->tanggal_selesai ? \Carbon\Carbon::parse($pm->tanggal_selesai)->format('d/m/Y') : 'Belum Diatur';
                                                $tanggalDiambil =  $pm->tanggal_diambil ? \Carbon\Carbon::parse($pm->tanggal_diambil)->format('d/m/Y') : 'Belum Diatur' ;
                                                $tanggalRencana =  $pm->tanggal_rencana ? \Carbon\Carbon::parse($pm->tanggal_rencana)->format('d/m/Y') : 'Belum Diatur' ;
                                                $tanggalPengumpulan = $pm->tanggal_pengumpulan ? \Carbon\Carbon::parse($pm->tanggal_pengumpulan)->format('d/m/Y') : 'Belum Diatur' ;

                                            @endphp
                                            <div id="permohonan-{{ $pm->id }}" class="hidden"
                                                data-id="{{ $pm->id}}"
                                                data-tgl-diajukan="{{ $tanggalDiajukan }}"
                                                data-kategori="{{ $pm->kategori_berbayar == 'Nolrupiah' ? 'Nol Rupiah' : $pm->kategori_berbayar }}"
                                                data-jenis-layanan="{{ $pm->jenisLayanan->nama_jenis_layanan ?? 'Tidak Diketahui' }}"
                                                data-deskripsi="{{ $pm->deskripsi_keperluan }}"
                                                data-disposisi1="{{$pm->disposisi->pegawai1->nama ?? 'Belum Diatur' }}"
                                                data-disposisi2="{{ $pm->disposisi->pegawai2->nama ?? 'Belum Diatur' }}"
                                                data-disposisi3="{{ $pm->disposisi->pegawai3->nama ?? 'Belum Diatur' }}"
                                                data-disposisi4="{{ $pm->disposisi->pegawai4->nama ?? 'Belum Diatur' }}"
                                                data-tgl-disposisi="{{ optional($pm->disposisi)->tanggal_disposisi ? \Carbon\Carbon::parse($pm->disposisi->tanggal_disposisi)->format('d/m/Y') : 'Belum Diatur' }}"
                                                data-pemohon="{{ $pm->pemohon->nama_pemohon ?? 'Tidak Diketahui' }}"
                                                data-instansi="{{ $pm->pemohon->instansi ?? 'Tidak Diketahui' }}"
                                                data-hp="{{ $pm->pemohon->no_kontak ?? 'Tidak Ada' }}"
                                                data-email="{{ $pm->pemohon->email ?? 'Tidak Ada' }}"
                                                data-tgl-selesai="{{ $tanggalSelesai}}"
                                                data-tgl-diambil="{{ $tanggalDiambil}}"
                                                data-tgl-rencana="{{ $tanggalRencana}}"
                                                data-tgl-pengumpulan="{{ $tanggalPengumpulan}}"
                                                data-status="{{ $pm->status_permohonan }}">
                                            </div>
                                           
                                            <div class="fixed inset-0 flex items-center justify-center p-4">
                                                <div class="relative bg-white p-5 w-full max-w-3xl rounded-lg shadow-lg max-h-screen overflow-y-auto">
                                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400" data-modal-toggle="add-modal">✖</button>
                                            
                                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white p-4 pb-3">
                                                            Detail Permohonan
                                                        </h3>
                                                    </div>
                                            
                                                    <div class="grid grid-cols-[max-content_1fr] gap-x-4 gap-y-2 p-4 text-gray-700">
                                                        <p class="font-semibold text-gray-900 self-start">ID Permohonan</p>
                                                        <p id="detail-id" class="text-gray-800"></p>

                                                        <p class="font-semibold text-gray-900 self-start">Tanggal Diajukan</p>
                                                        <p id="detail-tgl-diajukan" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Kategori Layanan</p>
                                                        <p id="detail-kategori" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Jenis Layanan</p>
                                                        <p id="detail-jenis-layanan" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Deskripsi Keperluan</p>
                                                        <p id="detail-deskripsi" class="text-gray-800 break-words"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Disposisi 1</p>
                                                        <p id="detail-disposisi1" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Disposisi 2</p>
                                                        <p id="detail-disposisi2" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Disposisi 3</p>
                                                        <p id="detail-disposisi3" class="text-gray-800"></p>

                                                        <p class="font-semibold text-gray-900 self-start">Disposisi 4</p>
                                                        <p id="detail-disposisi4" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Tanggal Disposisi</p>
                                                        <p id="detail-tgl-disposisi" class="text-gray-800"></p>

                                                        <p class="font-semibold text-gray-900 self-start">Tanggal Selesai</p>
                                                        <p id="detail-tgl-selesai" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Tanggal Diambil</p>
                                                        <p id="detail-tgl-diambil" class="text-gray-800"></p>
                                            
                                                        <!-- Field kondisional untuk skripsi. Hanya muncul ketika kategori berbayar = nol rupiah -->
                                                        <div id="skripsi-fields" class="contents hidden">
                                                            <p class="font-semibold text-gray-900 self-start">Tanggal Rencana Pengumpulan Skripsi</p>
                                                            <p id="detail-tgl-rencana" class="text-gray-800"></p>
                                                
                                                            <p class="font-semibold text-gray-900 self-start">Tanggal Pengumpulan Skripsi</p>
                                                            <p id="detail-tgl-pengumpulan" class="text-gray-800"></p>
                                                        </div>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Status Permohonan</p>
                                                        <p id="detail-status" class="text-gray-800"></p>
                                            
                                                        <!-- Garis Pemisah -->
                                                        <div class="border-b-2 border-gray-300 my-2 col-span-2"></div>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Pemohon</p>
                                                        <p id="detail-pemohon" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Instansi</p>
                                                        <p id="detail-instansi" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">No HP</p>
                                                        <p id="detail-hp" class="text-gray-800"></p>
                                            
                                                        <p class="font-semibold text-gray-900 self-start">Email</p>
                                                        <p id="detail-email" class="text-gray-800"></p>
                                            
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            </div>
                                        </div> 
                                        <script>
                                           
                                           function showDetail(id) {
                                            const permohonan = document.getElementById('permohonan-' + id);
                                            if (!permohonan) {
                                                console.error('Data permohonan tidak ditemukan untuk ID:', id);
                                                return;
                                            }

                                            const kategori_berbayar = permohonan.dataset.kategori.trim();
                                            const skripsiFields = document.getElementById('skripsi-fields');

                                            // Debugging: Cek apakah kategori terbaca dengan benar
                                            console.log("Kategori Berbayar:", kategori_berbayar);

                                            // Tampilkan/sembunyikan field skripsi berdasarkan kategori
                                            if (kategori_berbayar === 'Nol Rupiah') {
                                                skripsiFields.classList.remove('hidden');
                                            } else {
                                                skripsiFields.classList.add('hidden');
                                            }

                                            // Fungsi helper untuk mengatur warna teks
                                            function setTextWithColor(elementId, value) {
                                                const element = document.getElementById(elementId);
                                                if (["Belum Diatur", "Tidak Ada", "Tidak Diketahui"].includes(value)) {
                                                    element.style.color = 'red';  // Teks merah untuk nilai kosong
                                                } else {
                                                    element.style.color = ''; // Kembalikan ke warna default
                                                }
                                                element.textContent = value;
                                            }

                                            // Gunakan fungsi helper untuk setiap field
                                            setTextWithColor('detail-disposisi1', permohonan.getAttribute('data-disposisi1'));
                                            setTextWithColor('detail-disposisi2', permohonan.getAttribute('data-disposisi2'));
                                            setTextWithColor('detail-disposisi3', permohonan.getAttribute('data-disposisi3'));
                                            setTextWithColor('detail-disposisi4', permohonan.getAttribute('data-disposisi4'));
                                            setTextWithColor('detail-tgl-disposisi', permohonan.getAttribute('data-tgl-disposisi'));
                                            setTextWithColor('detail-pemohon', permohonan.getAttribute('data-pemohon'));
                                            setTextWithColor('detail-instansi', permohonan.getAttribute('data-instansi'));
                                            setTextWithColor('detail-hp', permohonan.getAttribute('data-hp'));
                                            setTextWithColor('detail-email', permohonan.getAttribute('data-email'));
                                            setTextWithColor('detail-tgl-selesai', permohonan.getAttribute('data-tgl-selesai'));
                                            setTextWithColor('detail-tgl-diambil', permohonan.getAttribute('data-tgl-diambil'));

                                             // Untuk field yang tidak perlu diwarnai, gunakan cara biasa
                                            document.getElementById('detail-id').textContent = permohonan.getAttribute('data-id');
                                            document.getElementById('detail-tgl-diajukan').textContent = permohonan.getAttribute('data-tgl-diajukan');
                                            document.getElementById('detail-kategori').textContent = permohonan.getAttribute('data-kategori');
                                            document.getElementById('detail-jenis-layanan').textContent = permohonan.getAttribute('data-jenis-layanan');
                                            document.getElementById('detail-deskripsi').textContent = permohonan.getAttribute('data-deskripsi');
                                            
                                             // Untuk field skripsi
                                            if (kategori_berbayar === 'Nol Rupiah') {
                                                setTextWithColor('detail-tgl-rencana', permohonan.dataset.tglRencana || 'Belum Diatur');
                                                setTextWithColor('detail-tgl-pengumpulan', permohonan.dataset.tglPengumpulan || 'Belum Diatur');
                                            } else {
                                                document.getElementById('detail-tgl-rencana').textContent = '-';
                                                document.getElementById('detail-tgl-pengumpulan').textContent = '-';
                                            }

                                            // Status formatting
                                            const status = permohonan.getAttribute('data-status');
                                                const statusElement = document.getElementById('detail-status');

                                                // Mapping status ke warna dan gaya yang sesuai
                                                let statusHTML = '';
                                                if (status === 'Diproses') {
                                                    statusHTML = '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300 inline-block">' + status + '</span>';
                                                } else if (status === 'Selesai Dibuat') {
                                                    statusHTML = '<span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400 inline-block">' + status + '</span>';
                                                } else if (status === 'Selesai Diambil') {
                                                    statusHTML = '<span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400 inline-block">' + status + '</span>';
                                                } else if (status === 'Batal') {
                                                    statusHTML = '<span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400 inline-block">' + status + '</span>';
                                                } else {
                                                    statusHTML = '<span class="text-gray-500">Status Tidak Diketahui</span>';
                                                }

                                            statusElement.innerHTML = statusHTML;

                                            // Tampilkan modal
                                            document.getElementById('add-modal').classList.remove('hidden');
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
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4">
                    <span class="text-sm font-normal text-gray-500">
                        Showing 
                        <span class="font-semibold text-gray-900">
                            {{ $permohonan->firstItem() }}-{{ $permohonan->lastItem() }} 
                        </span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">
                            {{ $permohonan->total() }}
                        </span>
                    </span>
                    
                    @if ($permohonan->hasPages())
                    <ul class="inline-flex items-stretch -space-x-px">
                        <!-- Previous Page Link -->
                        <li>
                            <a href="{{ $permohonan->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('months') ? '&months=' . request('months') : '' }}{{ request('year') ? '&year=' . request('year') : '' }}" 
                            class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-900 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 {{ $permohonan->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" />
                                </svg>
                            </a>
                        </li>

                        <!-- Pagination Links -->
                        @foreach ($permohonan->getUrlRange(1, $permohonan->lastPage()) as $page => $url)
                            @if ($page == 1 || $page == $permohonan->lastPage() || ($page >= $permohonan->currentPage() - 1 && $page <= $permohonan->currentPage() + 1))
                                <li>
                                    <a href="{{ $url }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('months') ? '&months=' . request('months') : '' }}{{ request('year') ? '&year=' . request('year') : '' }}" 
                                    class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 
                                    {{ $permohonan->currentPage() == $page ? 'z-10 text-primary-900 font-bold bg-primary-50 border-primary-300' : '' }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @elseif ($page == $permohonan->currentPage() - 2 || $page == $permohonan->currentPage() + 2)
                                <li>
                                    <span class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300">...</span>
                                </li>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        <li>
                            <a href="{{ $permohonan->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('months') ? '&months=' . request('months') : '' }}{{ request('year') ? '&year=' . request('year') : '' }}" 
                            class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-900 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 {{ !$permohonan->hasMorePages() ? 'cursor-not-allowed opacity-50' : '' }}">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                    @endif
                </nav>
            </div>
        </div> 
</x-app-layout>
