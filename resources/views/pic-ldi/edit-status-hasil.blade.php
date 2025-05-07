<x-app-layout>
   <div class="flex justify-center items-center px-4 lg:px-12">
       <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden w-full max-w-lg p-4">
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
               <h3 class="text-xl font-semibold text-gray-900 dark:text-white p-2 pb-3">
                   Edit Status Hasil Layanan
               </h3>
           </div>

           <form action="{{ route('pic-ldi.hasil-layanan.update', ['id' => $permohonan->id]) }}" method="POST" class="space-y-4">
               @csrf
               @method('PUT')
               <div class="grid grid-cols-1 mt-5">
                   <!-- Kode Permohonan -->
                   <label for="id_permohonan" class="block mb-2 text-sm font-medium text-gray-900">Kode Permohonan:</label>
                   <input type="text" class="text-sm bg-gray-200 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 cursor-not-allowed" name="id_permohonan" id="id_permohonan" value="{{ $permohonan->kode_permohonan }}" readonly>
               </div>

               <!-- Status -->
               <div class="grid grid-cols-1">
                   <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                       Status <span class="text-redNew">*</span>
                   </label>
                   <select id="status" name="status" class="text-sm border border-gray-200 rounded-lg block w-full p-2.5 transition-all" onchange="toggleKoreksi()">
                       <option value="pending" class="bg-yellow-200 text-yellow-900" {{ $permohonan->hasilLayanan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                       <option value="revisi" class="bg-red-200 text-red-900" {{ $permohonan->hasilLayanan->status == 'revisi' ? 'selected' : '' }}>Revisi</option>
                       <option value="disetujui" class="bg-green-200 text-green-900" {{ $permohonan->hasilLayanan->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                   </select>
               </div>

               <!-- Koreksi -->
               <div id="koreksi-container" class="grid grid-cols-1 {{ $permohonan->hasilLayanan->status == 'revisi' ? '' : 'hidden' }}">
                   <label for="koreksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                       Koreksi <span class="text-redNew">*</span>
                   </label>
                   <textarea id="koreksi" name="koreksi" class="text-sm border border-gray-300 rounded-lg block w-full p-2.5">{{ $permohonan->hasilLayanan->koreksi }}</textarea>
               </div>

               <div class="flex items-center justify-center mt-8">
                   <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                       Edit Status
                   </button> 
               </div>
           </form>
       </div>    
   </div>

   <script>
       function toggleKoreksi() {
           let statusSelect = document.getElementById("status");
           let koreksiContainer = document.getElementById("koreksi-container");

           if (statusSelect.value === "revisi") {
               koreksiContainer.classList.remove("hidden");
           } else {
               koreksiContainer.classList.add("hidden");
           }

           let selectedOption = statusSelect.options[statusSelect.selectedIndex];
           statusSelect.className = "text-sm border border-gray-300 rounded-lg block w-full p-2.5 transition-all";
           statusSelect.style.backgroundColor = selectedOption.classList.contains("bg-yellow-200") ? "#fefcbf" :
                                              selectedOption.classList.contains("bg-red-200") ? "#feb2b2" :
                                              selectedOption.classList.contains("bg-green-200") ? "#c6f6d5" : "";
       }

       document.addEventListener("DOMContentLoaded", function() {
           toggleKoreksi();
       });
   </script>
</x-app-layout>