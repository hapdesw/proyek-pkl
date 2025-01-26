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
                            <div id="actionsDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Pilih Bulan</h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="actionsDropdownButton">
                                    <li class="flex items-center">
                                        <input id="januari" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="januari" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Januari</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="februari" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="februari" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Februari</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="maret" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="maret" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Maret</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="april" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="april" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">April</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="mei" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="mei" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Mei</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="juni" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="juni" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Juni</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="juli" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="juli" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Juli</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="agustus" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="agustus" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Agustus</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="september" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="september" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">September</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="oktober" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="oktober" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Oktober</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="november" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="november" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">November</label>
                                    </li>
                                    <li class="flex items-center">
                                        <input id="desember" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="desember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Desember</label>
                                    </li>
                                </ul>
                            </div>
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
                        </div>
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
                                    <td class="px-3 py-3">{{ $loop->iteration }}</td>
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
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">{{ $pm->status_permohonan }}</span>
                                        @elseif($pm->status_permohonan === 'Selesai')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">{{ $pm->status_permohonan }}</span>
                                        @elseif($pm->status_permohonan === 'Batal')
                                            <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-red-400 border border-red-400">{{ $pm->status_permohonan }}</span>
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
                                                    <li class=" flex items-center px-4 py-1" >
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m4 8h6m-6-4h6m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z"/>
                                                        </svg>

                                                        <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Detail</a>
                                                    </li>
                                                </div>
                                                <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <li class=" flex items-center px-4 py-1" >
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m14 9.006h-.335a1.647 1.647 0 0 1-1.647-1.647v-1.706a1.647 1.647 0 0 1 1.647-1.647L19 12M5 12v5h1.375A1.626 1.626 0 0 0 8 15.375v-1.75A1.626 1.626 0 0 0 6.375 12H5Zm9 1.5v2a1.5 1.5 0 0 1-1.5 1.5v0a1.5 1.5 0 0 1-1.5-1.5v-2a1.5 1.5 0 0 1 1.5-1.5v0a1.5 1.5 0 0 1 1.5 1.5Z"/>
                                                        </svg>
                                                        <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Lihat Hasil Layanan</a>
                                                    </li>
                                                </div>
                                                <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <li class=" flex items-center px-4 py-1">
                                                    @if($pm->disposisi && ($pm->disposisi->pegawai1 || $pm->disposisi->pegawai2 || $pm->disposisi->pegawai3))

                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                        </svg>
                                                        <a href="{{ route('kapokja.disposisi.edit', ['id' => $pm->id]) }}" 
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                        Edit Disposisi
                                                        </a>
                                                    @else
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                        </svg>
                                                        <a href="{{ route('kapokja.disposisi.create', ['id' => $pm->id]) }}" 
                                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                        Atur Disposisi
                                                        </a>
                                                    @endif
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
                                            </ul>
                                        </div>
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
            </div>
        </div> 
</x-app-layout>
