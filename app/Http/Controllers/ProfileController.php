<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Menampilkan form untuk mengedit profil.
     * Dapat diakses oleh semua user yang sudah login.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna (nama, email, foto, dan password).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // ProfileUpdateRequest sudah memvalidasi 'name' dan 'email'
        $user = $request->user();

        // Mengisi data nama dan email yang sudah divalidasi
        $user->fill($request->validated());

        // Jika email diubah, reset status verifikasi email
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Validasi tambahan untuk foto dan password
        $request->validate([
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan foto baru dan update path di database
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }
        
        // Perbarui password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan semua perubahan ke database
        $user->save();

        // Redirect kembali ke halaman pengaturan di dashboard admin dengan pesan sukses
        // Cek jika user adalah admin, redirect ke dashboard. Jika tidak, ke profile.edit biasa.
        if ($user->role->name === 'admin') {
            return Redirect::route('admin.dashboard', ['_fragment' => 'pengaturan'])->with('success', 'Pengaturan akun berhasil diperbarui!');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun pengguna secara permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validasi password untuk konfirmasi penghapusan akun
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Logout pengguna sebelum menghapus
        Auth::logout();

        // Hapus juga foto profil dari storage
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        
        $user->delete();

        // Invalidate session dan regenerate token untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return Redirect::to('/');
    }
}