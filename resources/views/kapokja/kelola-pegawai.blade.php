<x-app-layout>
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
                        Pegawai
                    </h3>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/3">
                    <form action="{{ route('kapokja.kelola-pegawai') }}" method="GET" class="flex items-center">
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
                            <div>
                                <a href="{{route ('kapokja.kelola-pegawai.create') }}">
                                    <button class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none dark:focus:ring-primary-800">
                                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                        </svg>
                                        Tambah Pegawai
                                    </button> 
                                </a>    
                            </div>            
                        </div>
                    </div>
                </div>
                {{-- Tabel --}}
                <div class="overflow-x-auto  min-h-screen">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-sm text-darkKnight uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                            <th scope="col" class="px-4 py-3">No.</th>
                                <th scope="col" class="px-4 py-3">NIP</th>
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3">Peran</th>
                                <th scope="col" class="px-4 py-3">Aksi</th> 
                            </tr>
                        </thead>
                        <tbody id="table-body" class="text-darkKnight">
                        @forelse ($pegawai as $pgw)

                                <tr class="border-b dark:border-gray-700">
                                <td class="px-3 py-3">{{ ($pegawai->currentPage() - 1) * $pegawai->perPage() + $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $pgw->nip }}</td>
                                    <td class="px-4 py-3">{{ $pgw->nama }}</td>
                                    <td class="px-4 py-3">
                                        @if ($pgw->peran_pegawai == '1000')
                                            Admin
                                        @elseif ($pgw->peran_pegawai == '0100')
                                            Kapokja
                                        @elseif ($pgw->peran_pegawai == '0010')
                                            Analis
                                        @elseif ($pgw->peran_pegawai == '0001')
                                            Bendahara
                                        @elseif ($pgw->peran_pegawai == '0110')
                                            Kapokja dan Analis
                                        @elseif ($pgw->peran_pegawai == '0011')
                                            Analis dan Bendahara
                                        @elseif ($pgw->peran_pegawai == '0101')
                                            Kapokja dan Bendahara
                                        @else
                                            Tidak Diketahui
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 flex items-center">
                                        <button id="actions-dropdown-button-{{ $pgw->nip }}" data-dropdown-toggle="actions-dropdown-{{ $pgw->nip }}" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="actions-dropdown-{{ $pgw->nip }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actions-dropdown-button-{{ $pgw->nip }}">
                                                <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <li class=" flex px-4 py-1">
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                        </svg>
                                                          
                                                        <a href="{{ route('kapokja.kelola-pegawai.edit', $pgw->nip) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                    </li>
                                                </div>
                                                <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <li class=" flex px-4 py-1">
                                                    <form id="delete-form-{{ $pgw->nip }}" 
                                                            action="{{ route('kapokja.kelola-pegawai.destroy', $pgw->nip) }}" 
                                                            method="POST" 
                                                            class="flex items-center">
                                                            @csrf
                                                            @method('DELETE')
                                                            
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                            </svg>
                                                            
                                                            <button type="button" 
                                                                    onclick="confirmDelete('{{  $pgw->nip }}')" 
                                                                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </li>   
                                                </div>
                                                <script>
                                                function confirmDelete(nip) {
                                                    Swal.fire({
                                                        title: 'Apakah Anda yakin?',
                                                        text: "Data pegawai akan dihapus secara permanen!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Ya, hapus!',
                                                        cancelButtonText: 'Batal'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            document.getElementById('delete-form-' +nip).submit();
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
                                <td colspan="10" class="text-center align-middle h-20">Tidak ada pegawai</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4">
                    <span class="text-sm font-normal text-gray-500">
                        Showing 
                        <span class="font-semibold text-gray-900">
                            {{ $pegawai->firstItem() }}-{{ $pegawai->lastItem() }} 
                        </span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">
                            {{ $pegawai->total() }}
                        </span>
                    </span>
                    
                    @if ($pegawai->hasPages())
                    <ul class="inline-flex items-stretch -space-x-px">
                        <!-- Previous Page Link -->
                        <li>
                            <a href="{{ $pegawai->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}" 
                            class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-900 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 {{ $pegawai->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" />
                                </svg>
                            </a>
                        </li>

                        <!-- Pagination Links -->
                        @foreach ($pegawai->getUrlRange(1, $pegawai->lastPage()) as $page => $url)
                            @if ($page == 1 || $page == $pegawai->lastPage() || ($page >= $pegawai->currentPage() - 1 && $page <= $pegawai->currentPage() + 1))
                                <li>
                                    <a href="{{ $url }}{{ request('search') ? '&search=' . request('search') : '' }}" 
                                    class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 
                                    {{ $pegawai->currentPage() == $page ? 'z-10 text-primary-900 font-bold bg-primary-50 border-primary-300' : '' }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @elseif ($page == $pegawai->currentPage() - 2 || $page == $pegawai->currentPage() + 2)
                                <li>
                                    <span class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300">...</span>
                                </li>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        <li>
                            <a href="{{ $pegawai->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}" 
                            class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-900 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 {{ !$pegawai->hasMorePages() ? 'cursor-not-allowed opacity-50' : '' }}">
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
