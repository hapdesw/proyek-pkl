<?php

namespace App\Observers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PegawaiObserver
{
    /**
     * Handle the Pegawai "created" event.
     */
    public function created(Pegawai $pegawai): void
    {
        //
    }

    /**
     * Handle the Pegawai "updated" event.
     */
    public function updated(Pegawai $pegawai): void
    {
        if ($pegawai->isDirty('peran_pegawai') && $pegawai->id_user) {
            try {
                DB::beginTransaction();
                
                $result = User::where('id', $pegawai->id_user)
                    ->update(['peran' => $pegawai->peran_pegawai]);
                
                if (!$result) {
                    // Log jika tidak ada baris yang diupdate (user mungkin tidak ditemukan)
                    Log::warning("Gagal update peran user untuk pegawai {$pegawai->nip}. User ID {$pegawai->id_user} tidak ditemukan.");
                    throw new \Exception("User tidak ditemukan");
                }
                
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error saat sinkronisasi peran dari pegawai ke user: {$e->getMessage()}");
            }
        }
    }

    /**
     * Handle the Pegawai "deleted" event.
     */
    public function deleted(Pegawai $pegawai): void
    {
        //
    }

    /**
     * Handle the Pegawai "restored" event.
     */
    public function restored(Pegawai $pegawai): void
    {
        //
    }

    /**
     * Handle the Pegawai "force deleted" event.
     */
    public function forceDeleted(Pegawai $pegawai): void
    {
        //
    }
}
