<header class="bg-gray-800 p-3">
    <div class="flex justify-between items-center">
        <!-- Left side -->
        <div class="flex items-center">
            <div class="text-white text-lg font-bold">SIPRES</div>
        </div>

        <!-- Right side (Icons) -->
        <div class="flex items-center space-x-4 absolute right-5" x-data="{ open: false }">
            <!-- Icon Profile -->
            <a href="#" @click="open = !open" class="text-white mr-0 relative" title="Profil">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9.985 9.985 0 0112 15c2.45 0 4.687.88 6.879 2.804M12 3a9 9 0 100 18 9 9 0 000-18zm0 10a4 4 0 110-8 4 4 0 010 8z" />
                </svg>
            </a>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>