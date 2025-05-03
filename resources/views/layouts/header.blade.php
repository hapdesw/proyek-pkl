<header class="p-3" style="background-color: #0F172A;">
    <div class="flex justify-between items-center">
        <!-- Left side -->
        <div class="flex items-center">
            <div class="text-white text-lg font-semibold">Sistem Layanan Data dan Informasi</div>
        </div>

        <!-- Right side (Icons and Profile Badge) -->
        <div class="flex items-center space-x-4 absolute right-5" x-data="{ open: false }">
            <!-- Profile Badge -->
            <div class="flex items-center space-x-2 cursor-pointer" @click="open = !open">
                <!-- Icon Profile -->
                <div class="text-white">
                    <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </div>

                <!-- Nama dan Peran -->
                <div class="text-sm text-white text-left">
                    <div class="font-medium">
                        @if(Auth::check() && Auth::user()->peran === '1000')
                            Admin
                        @else
                            {{ Auth::user()->pegawai->nama }}
                        @endif
                    </div>
                    <div class="text-xs text-gray-300">
                        @if(Auth::check() || session()->has('active_role'))
                            @php
                                $role = '';
                                if (Auth::user()->peran === '1000' || session('active_role') === '1000') {
                                    $role = 'Admin';
                                } elseif (Auth::user()->peran === '0100' || session('active_role') === '0100') {
                                    $role = 'PIC LDI';
                                } elseif (Auth::user()->peran === '0010' || session('active_role') === '0010') {
                                    $role = 'Analis';
                                } elseif (Auth::user()->peran === '0001' || session('active_role') === '0001') {
                                    $role = 'Bendahara';
                                }
                            @endphp
                            {{ $role }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-12 w-48 bg-white rounded-md shadow-lg z-20">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>