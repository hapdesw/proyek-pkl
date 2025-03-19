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
                        Hasil Layanan
                    </h1>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/3">
                    <form action="{{ route('kapokja.hasil-layanan') }}" method="GET" class="flex items-center">
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

                                    <!-- Filter Status -->
                                    <h3 class="font-semibold mt-4 mb-2">Pilih Status Hasil Layanan</h3>
                                    <select id="statusFilter" class="w-full p-2 border rounded">
                                        <option value="">Semua</option>
                                        <option value="pending">Pending</option>
                                        <option value="revisi">Revisi</option>
                                        <option value="disetujui">Disetujui</option>
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
                            const statusSelect = document.getElementById('statusFilter');

                            filterButton.addEventListener('click', function () {
                                filterDropdown.style.display = (filterDropdown.style.display === 'none') ? 'block' : 'none';
                            });

                            document.addEventListener('click', function (event) {
                                if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                                    filterDropdown.style.display = 'none';
                                }
                            });

                            fetch('/kapokja/hasil-layanan/available-years')
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
                                const selectedStatus = statusSelect.value;

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

                                // Hanya tambahkan parameter `status` jika status status dipilih
                                if (selectedStatus) {
                                    url.searchParams.set('status', selectedStatus);
                                } else {
                                    url.searchParams.delete('status');
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
                        <thead class="text-xs text-gray-800 uppercase bg-gray-100 ">
                            <tr>
                                <th scope="col" class="px-3 py-3">No.</th>
                                <th scope="col" class="px-4 py-3">ID</th>
                                <th scope="col" class="px-3 py-3">Tanggal Pengajuan</th>
                                <th scope="col" class="px-1.5 py-3">Kategori</th>
                                <th scope="col" class="px-2.5 py-3">Layanan</th>
                                <th scope="col" class="px-3 py-3 w-36">Pemohon</th>
                                <th scope="col" class="px-3 py-3">Keperluan</th>
                                <th scope="col" class="px-2 py-2">Status</th>
                                <th scope="col" class="px-4 py-3 w-48">Koreksi</th>
                                <th scope="col" class="px-3 py-3">File Hasil Layanan</th>
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
                                    <td class="px-2 py-2">
                                        @if ($pm->hasilLayanan)
                                            @if($pm->hasilLayanan->status === 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Pending</span>
                                            @elseif($pm->hasilLayanan->status === 'disetujui')
                                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Disetujui</span>
                                            @elseif($pm->hasilLayanan->status === 'revisi')
                                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-red-400 border border-red-400">Revisi</span>
                                            @endif
                                        </td>
                                    @else
                                            <span class="text-gray-500">Hasil layanan belum diunggah</span>
                                    @endif
                                    </td>
                                    <td class="px-3 py-3 w-48">
                                        @if(!empty($pm->hasilLayanan->koreksi))
                                            {{ $pm->hasilLayanan->koreksi }}
                                        @else
                                            <span class="text-gray-500">Tidak ada koreksi</span>
                                        @endif
                                    </td>  
                                    <td class="px-4 py-3 w-32">
                                        @if($pm->hasilLayanan)
                                            <button onclick="window.open('{{ asset('storage/' . $pm->hasilLayanan->path_file_hasil) }}', '_blank')" class="px-2.5 py-0.5 bg-blue-700 text-white text-xs rounded hover:bg-blue-800 transition duration-300">
                                                Lihat File
                                            </button>
                                            <span class="text-xs text-gray-600">
                                                {{ $pm->hasilLayanan->updated_at ? 'Diperbarui oleh:' : 'Diunggah oleh:' }}
                                            </span>
                                            <span class="text-xs font-medium">{{ $pm->hasilLayanan->pegawai->nama }}</span>
                                        @else
                                            <span class="text-gray-500">Hasil layanan belum diunggah</span>
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
                                                @if($pm->hasilLayanan && $pm->hasilLayanan->path_file_hasil)
                                                    @if($pm->hasilLayanan->status === 'pending')
                                                        <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                            <li class="flex items-center px-4 py-1">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                                </svg>
                                                                <a href="{{ route('kapokja.hasil-layanan.create', ['id' => $pm->id]) }}" 
                                                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                                    Atur Status
                                                                </a>
                                                            </li>
                                                        </div>
                                                    @else
                                                        <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                            <li class="flex items-center px-4 py-1">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                                </svg>
                                                                <a href="{{ route('kapokja.hasil-layanan.edit', ['id' => $pm->id]) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                                    Edit
                                                                </a>
                                                            </li>
                                                        </div>
                                                        <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                            <li class="flex items-center px-4 py-1">
                                                                <form id="delete-form-{{ $pm->id }}" action="{{ route('kapokja.hasil-layanan.destroy', ['id' => $pm->id]) }}" method="POST" class="flex items-center">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                                    </svg>
                                                                    <button type="button" onclick="confirmDelete({{ $pm->id }})" 
                                                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                                        Hapus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        <li class="flex items-center px-4 py-1">
                                                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                            </svg>
                                                            <span class="ml-2 text-red-500">Hasil layanan belum diunggah</span>
                                                        </li>
                                                    </div>
                                                @endif
                                            </ul>
                                        </div>
                                        <script>
                                        function confirmDelete(id) {
                                            Swal.fire({
                                                title: 'Apakah Anda yakin?',
                                                text: "Status hasil layanan akan dihapus secara permanen!",
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
