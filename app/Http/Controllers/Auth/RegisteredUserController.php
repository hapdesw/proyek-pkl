<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ini log
        Log::info('Mulai daftar dakun');
        $request->validate([
            'nip_register' => ['required', 'string'],
            'username_register' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password_register' => ['required', 'confirmed', Rules\Password::defaults()],
            
        ]);

        // cek apakah nip sudah terdaftar di pegawai
        $pegawai = Pegawai::where('nip', $request->nip_register)->whereNull('id_user')->first();
        
        if(!$pegawai){
            return redirect()->back()->withErrors(['nip_register' => 'NIP tersebut tidak terdaftar atau sudah digunakan.'])->withInput();
        }

        log::info('Create user');
        // Buat user
        $user = User::create([
            'username' => $request->username_register,
            'password' => Hash::make($request->password_register),
            'peran' => $pegawai->peran_pegawai,
        ]);

        // Update id_user di tabel pegawai
        $pegawai->id_user = $user->id;
        $pegawai->save();

        event(new Registered($user));

        Auth::login($user);

        // setelah daftar direct ke beranda masing-masing peran pegawai
        switch ($user->peran) {
            case '1000':
                return redirect()->route('admin.beranda');
            case '0100':
                return redirect()->route('pic-ldi.beranda');
            case '0010':
                return redirect()->route('analis.hasil-layanan');
            case '0001':
                return redirect()->route('bendahara.tagihan');
            case '0110':
                return redirect()->route('transisi.pic-ldi-analis');
            case '0011':
                return redirect()->route('transisi.analis-bendahara');
            case '0101':
                return redirect()->route('transisi.pic-ldi-bendahara');
            default:
                return redirect()->route('login');
        }
        
        Log::info('Akun berhasil dibuat');
    }
}
