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
                        <a href="{{ route('petugas.kelola-layanan') }}" class="flex items-center p-2 rounded hover:bg-gray-100 hover:text-gray-400 font-semibold 
                        {{ request()->routeIs('petugas.kelola-layanan') ? ' 
                        text-darkKnight font-bold' : 'text-plumb' }}">Kelola Layanan</a>
                    </li>
                    <li>
                        <a href="{{ route('petugas.kelola-pemohon') }}" class="flex items-center p-2 rounded hover:bg-gray-100 hover:text-gray-400 font-semibold 
                        {{ request()->routeIs('petugas.kelola-pemohon') ? ' 
                        text-darkKnight font-bold' : 'text-plumb' }}">Pemohon</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
