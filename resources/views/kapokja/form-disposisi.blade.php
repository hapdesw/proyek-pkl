<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("halo!") }}
                </div>
                <a href="{{ route('kapokja.disposisi.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-6 inline-block hover:bg-green-600">
                + Atur disposisi
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
