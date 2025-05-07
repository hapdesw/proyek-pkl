<header>
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-3 shadow-md">
        <div class="flex flex-wrap justify-center items-center mx-auto max-w-screen-xl">
            <div class="hidden justify-center items-center w-full lg:flex lg:w-auto" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">

                    <!-- Menu Beranda -->
                    <li class="relative group">
                        <a href="{{ route('superadmin.beranda') }}" class="flex items-center p-2 rounded hover:bg-gray-100 font-semibold 
                        {{ request()->routeIs('superadmin.beranda') ? 'text-darkKnight font-bold' : 'text-plumb' }}">
                            Beranda
                        </a>
                    </li>

                    @php
                        $adminActive = request()->routeIs('admin.permohonan') ||
                                       request()->routeIs('admin.kelola-layanan') ||
                                       request()->routeIs('admin.kelola-pemohon');

                        $ldiActive = request()->routeIs('pic-ldi.disposisi') ||
                                     request()->routeIs('pic-ldi.hasil-layanan') ||
                                     request()->routeIs('pic-ldi.kelola-pegawai');

                        

                        $bendaharaActive = request()->routeIs('bendahara.tagihan') ||
                                           request()->routeIs('bendahara.kuitansi');
                    @endphp

                    <!-- Menu Admin -->
                    <li class="relative">
                        <button class="dropdown-button flex items-center p-2 rounded hover:bg-gray-100 font-semibold focus:outline-none
                            {{ $adminActive ? 'text-darkKnight font-bold' : 'text-plumb' }}">
                            Admin
                            <svg class="w-2.5 h-2.5 ml-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute z-10 hidden bg-white shadow-lg rounded-md w-48 mt-1 py-1">
                            <a href="{{ route('admin.permohonan') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengajuan Permohonan</a>
                            <a href="{{ route('admin.kelola-layanan') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelola Jenis Layanan</a>
                            <a href="{{ route('admin.kelola-pemohon') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelola Pemohon</a>
                        </div>
                    </li>

                    <!-- Menu PIC LDI -->
                    <li class="relative">
                        <button class="dropdown-button flex items-center p-2 rounded hover:bg-gray-100 font-semibold focus:outline-none
                            {{ $ldiActive ? 'text-darkKnight font-bold' : 'text-plumb' }}">
                            PIC LDI
                        </button>
                        <div class="dropdown-menu absolute z-10 hidden bg-white shadow-lg rounded-md w-48 mt-1 py-1">
                            <a href="{{ route('pic-ldi.disposisi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Disposisi</a>
                            <a href="{{ route('pic-ldi.hasil-layanan') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hasil Layanan</a>
                            <a href="{{ route('pic-ldi.kelola-pegawai') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelola Pegawai</a>
                        </div>
                    </li>

                    

                    <!-- Menu Bendahara -->
                    <li class="relative">
                        <button class="dropdown-button flex items-center p-2 rounded hover:bg-gray-100 font-semibold focus:outline-none
                            {{ $bendaharaActive ? 'text-darkKnight font-bold' : 'text-plumb' }}">
                            Bendahara
                            <svg class="w-2.5 h-2.5 ml-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute z-10 hidden bg-white shadow-lg rounded-md w-48 mt-1 py-1">
                            <a href="{{ route('bendahara.tagihan') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tagihan</a>
                            <a href="{{ route('bendahara.kuitansi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kuitansi</a>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- JavaScript -->
<script>
    const buttons = document.querySelectorAll('.dropdown-button');
    const menus = document.querySelectorAll('.dropdown-menu');

    buttons.forEach((button, index) => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            menus.forEach((menu, i) => {
                if (i !== index) menu.classList.add('hidden');
            });
            menus[index].classList.toggle('hidden');
        });
    });

    document.addEventListener('click', function () {
        menus.forEach(menu => menu.classList.add('hidden'));
    });
</script>

<!-- CSS Animasi -->
<style>
    .dropdown-menu {
        animation: fadeIn 0.2s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
