<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Method ini bertugas untuk MENAMPILKAN halaman form registrasi.
     * Ia HANYA boleh me-return view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Method ini bertugas untuk MEMPROSES data dari form registrasi.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim_nidn' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $mahasiswaRoleId = Role::where('name', 'mahasiswa')->firstOrFail()->id;

        $user = User::create([
            'name' => $request->name,
            'nim_nidn' => $request->nim_nidn,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $mahasiswaRoleId,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}