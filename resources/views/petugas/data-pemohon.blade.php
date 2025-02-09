<x-app-layout>
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12"> 
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden ml-16 mr-16 flex flex-col">
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
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white p-4 pb-3">
                    Kelola Pemohon
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
                                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
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
                                    <!-- Tahun akan diisi dengan JavaScript -->
                                </select>
                        
                                <!-- Tombol Terapkan -->
                                <button id="applyFilter" class="mt-4 w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                                    Terapkan
                                </button>
                            </div>
                        </div>
                    </div>   
                </div>    
            </div>
            {{-- Tabel --}}
            <div class="overflow-x-auto  min-h-screen">
                @php
                $displayedNames = [];
            @endphp
            
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">No.</th>
                        <th scope="col" class="px-4 py-3">Nama Pemohon</th>
                        <th scope="col" class="px-4 py-3">Instansi</th> 
                        <th scope="col" class="px-4 py-3">No. Hp</th> 
                        <th scope="col" class="px-4 py-3">Email</th> 
                        <th scope="col" class="px-4 py-3">Total Permohonan</th> 
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemohon as $index => $pmh)
                        <tr class="border-b dark:border-gray-700 text-darkKnight">
                            <td class="px-4 py-3">{{ $pemohon->firstItem() + $index }}</td>
                            <td class="px-4 py-3">{{ $pmh->nama_pemohon }}</td>
                            <td class="px-4 py-3">{{ $pmh->instansi }}</td>
                            <td class="px-4 py-3">
                                @if($pmh->no_kontak)
                                    {{ $pmh->no_kontak }}
                                @else
                                    <span class="text-red-500">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($pmh->email)
                                    {{ $pmh->email }}
                                @else
                                    <span class="text-red-500">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $pmh->total_permohonan }}</td>
                        </tr> 
                    @empty
                        <tr>
                            <td colspan="10" class="text-center align-middle h-20">Tidak ada data pemohon</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
          
            </div>
            <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4">
                <span class="text-sm font-normal text-gray-500">
                    Showing 
                    <span class="font-semibold text-gray-900">
                        {{ $pemohon->firstItem() }}-{{ $pemohon->lastItem() }} 
                    </span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">
                    {{ $pemohon->total() }}
                    </span>
                </span>
                
                @if ($pemohon->hasPages())
                <ul class="inline-flex items-stretch -space-x-px">
                    <li>
                        <a href="{{ $pemohon->previousPageUrl() }}" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-900 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 {{ $pemohon->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
                            <span class="sr-only">Previous</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" />
                            </svg>
                        </a>
                    </li>

                    @foreach ($pemohon->getUrlRange(1, $pemohon->lastPage()) as $page => $url)
                        @if ($page == 1 || $page == $pemohon->lastPage() || ($page >= $pemohon->currentPage() - 1 && $page <= $pemohon->currentPage() + 1))
                            <li>
                                <a href="{{ $url }}" 
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 
                                {{ $pemohon->currentPage() == $page ? 'z-10 text-primary-900 font-bold bg-primary-50 border-primary-300' : '' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @elseif ($page == $pemohon->currentPage() - 2 || $page == $pemohon->currentPage() + 2)
                            <li>
                                <a class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">...</a>
                            </li>
                        @endif
                    @endforeach

                    <li>
                        <a href="{{ $pemohon->nextPageUrl() }}" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-900 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 {{ !$pemohon->hasMorePages() ? 'cursor-not-allowed opacity-50' : '' }}">
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
