<header>
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-3">
        <div class="flex flex-wrap justify-center items-center mx-auto max-w-screen-xl">
            <div class="hidden justify-center items-center w-full lg:flex lg:w-auto" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="{{ route('petugas.beranda') }}" class="flex items-center p-2 rounded hover:bg-gray-100 hover:text-gray-400 font-semibold 
                        {{ request()->routeIs('petugas.beranda') ? ' text-darkKnight font-bold' : 'text-plumb' }}">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('petugas.permohonan') }}" class="flex items-center p-2 rounded hover:bg-gray-100 hover:text-gray-400 font-semibold 
                        {{ request()->routeIs('petugas.permohonan') ? ' text-darkKnight font-bold' : 'text-plumb' }}">Pengajuan Permohonan</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0">Kelola Layanan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
