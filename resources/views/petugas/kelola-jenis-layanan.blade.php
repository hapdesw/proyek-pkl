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
                    Kelola Jenis Layanan
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
                        <div x-data="{ open: false }">
                            <button data-modal-target="add-modal"  data-modal-toggle="add-modal" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                                </svg>
                                Tambah Layanan
                            </button> 
                            {{-- Modal Tambah Layanan --}}
                            <div id="add-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-1/2 h-auto max-w-screen-xl mx-auto">
                                    <div class="relative bg-white p-6 w-full max-w-full rounded-lg shadow-lg">
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400" data-modal-toggle="add-modal">✖</button>
                                        <div class="border-b border-gray-200 dark:border-gray-700">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white p-4 pb-3">
                                                Tambah Layanan
                                            </h3>
                                        </div>
                                        
                                        <form action="{{route ('petugas.kelola-layanan.store') }}" method="POST" class="space-y-4">
                                            @csrf
                                            <div class="grid grid-cols-1 gap-4">
                                                <!-- Nama Layanan-->
                                                <div>
                                                    <label for="nama_jenis_layanan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Layanan</label>
                                                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="nama_jenis_layanan" name="nama_jenis_layanan" required>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-4 mt-4">
                                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    Tambah
                                                </button> 
                                            </div>
                                        </form> 
                                    </div> 
                                </div>
                                
                            </div>                          
                        </div>            
                    </div>
                </div>
            </div>
            {{-- Tabel --}}
            <div class="overflow-x-auto  min-h-screen">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No.</th>
                            <th scope="col" class="px-4 py-3">Nama Jenis Layanan</th> 
                            <th scope="col" class="px-4 py-3">Aksi</th> 
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @forelse ($jenislayanan as $layanan)

                            <tr class="border-b dark:border-gray-700 text-darkKnight">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $layanan->nama_jenis_layanan }}</td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button id="actions-dropdown-button-{{ $layanan->id }}" data-dropdown-toggle="actions-dropdown-{{ $layanan->id }}" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div id="actions-dropdown-{{ $layanan->id }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actions-dropdown-button-{{ $layanan->id }}">
                                            <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <li class=" flex px-4 py-1">
                                                    <button type="button" data-modal-target="edit-modal-{{ $layanan->id }}" data-modal-toggle="edit-modal-{{ $layanan->id }}" aria-controls="edit-modal-{{ $layanan->id }}" class="flex items-center gap-2 py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                        </svg>
                                                        Edit Layanan
                                                    </button>
                                                              
                                                </li>
                                            </div>
                                            {{-- Untuk Hapus data per layanan --}}
                                            <div class="block px-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <li class=" flex items-center px-2 py-1">
                                                    <form id="delete-form-{{$layanan->id}}" action="{{ route('petugas.kelola-layanan.destroy', $layanan->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="openDialog('custom-confirm-{{$layanan->id}}')" class="flex items-center gap-2 py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                            </svg>
                                                            <span>Hapus</span>
                                                        </button>
                                                    </form>
                                                </li> 
                                            </div>  
                                        </ul>
                                    </div>
                                    {{-- Buka modal untuk edit --}}
                                    <div id="edit-modal-{{ $layanan->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-1/2 h-auto max-w-screen-xl mx-auto">
                                            <div class="relative bg-white p-6 w-full max-w-full rounded-lg shadow-lg">
                                                <button type="button" class="absolute top-3 right-2.5 text-gray-400" data-modal-toggle="edit-modal-{{ $layanan->id }}">✖</button>
                                                <div class="border-b border-gray-200 dark:border-gray-700">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white p-4 pb-3">
                                                        Edit Layanan
                                                    </h3>
                                                </div>
                                                
                                                <form action="{{route ('petugas.kelola-layanan.update', $layanan->id) }}" method="POST" class="space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid grid-cols-1 gap-4">
                                                        <!-- Nama Layanan-->
                                                        <div>
                                                            <label for="nama_jenis_layanan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Layanan</label>
                                                            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="nama_jenis_layanan" name="nama_jenis_layanan" value="{{ $layanan->nama_jenis_layanan }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-4 mt-4">
                                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                            Simpan Perubahan
                                                        </button> 
                                                    </div>
                                                </form> 
                                            </div> 
                                        </div>
                                    </div>         
                                    {{-- Pop up dialog untuk hapus --}}
                                    <div id="custom-confirm-{{$layanan->id}}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm">
                                            <p class="mb-4">Apakah Anda yakin ingin menghapus layanan <strong>{{ $layanan->nama_jenis_layanan }}</strong>?</p>
                                            <div class="flex gap-3">
                                                <button onclick="closeDialog('custom-confirm-{{$layanan->id}}')" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-3 py-2 rounded">Batal</button>
                                                <button onclick="submitForm('delete-form-{{$layanan->id}}')" class="bg-red hover:bg-orange-900 text-white px-2 py-2 rounded">Hapus</button>
                                            </div>
                                        </div>
                                    </div>  
                                    <script>
                                        function openDialog(dialogId) {
                                            document.getElementById(dialogId).classList.remove('hidden');
                                        }
                
                                        function closeDialog(dialogId) {
                                            document.getElementById(dialogId).classList.add('hidden');
                                        }
                
                                        function submitForm(formId) {
                                            document.getElementById(formId).submit();
                                        }
                                    </script>
                                </td>
                            </tr> 
                        @empty
                        <tr>
                            <td colspan="10" class="text-center align-middle h-20">Tidak ada Layanan</td>
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
