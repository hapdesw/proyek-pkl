<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PasswordController extends Controller
{
    /**
     * Proses update password
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|size:18',
            'username' => 'required|string|max:30',
            'password' => [
                'required',
                'string',
                Password::min(8)->numbers()
            ],
            'captcha' => 'required|captcha',
        ], [
            'nip.size' => 'NIP harus terdiri dari 18 karakter',
            'captcha.captcha' => 'Captcha tidak valid',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $pegawai = Pegawai::where('nip', $request->nip)->first();
            
            if (!$pegawai) {
                throw new \Exception('NIP tidak ditemukan');
            }

            if (!$pegawai->id_user) {
                throw new \Exception('Akun tidak terdaftar');
            }

            $user = User::where('id', $pegawai->id_user)
                ->where('username', $request->username)
                ->first();

            if (!$user) {
                throw new \Exception('Username tidak sesuai dengan NIP');
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Password berhasil diubah. Silakan login dengan password baru Anda.',
                    'redirect' => route('login')
                ]);
            }

            return redirect()->route('login')
                ->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 400);
            }
            
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}