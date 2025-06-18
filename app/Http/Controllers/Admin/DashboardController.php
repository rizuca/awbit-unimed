<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Course;
use App\Models\Material; // Pastikan model Material di-import
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $admin = auth()->user();
        $dosenRoleId = Role::where('name', 'dosen')->value('id');
        $mahasiswaRoleId = Role::where('name', 'mahasiswa')->value('id');

        // Statistik
        $totalDosen = User::where('role_id', $dosenRoleId)->count();
        $totalMahasiswa = User::where('role_id', $mahasiswaRoleId)->count();
        $totalKelas = Course::count();
        $totalMateri = Material::count(); // Tetap untuk statistik

        // --- BAGIAN BARU: Mengambil data materi ---
        // Mengambil semua materi beserta relasi ke section, course, dan lecturer
        $materials = Material::with('section.course.lecturer')->latest()->get();

        // Data Manajemen Dosen
        $dosens = User::where('role_id', $dosenRoleId)->latest()->get();
        
        // Data Manajemen Kelas
        $allCourses = Course::with('lecturer')->latest()->get();

        // Data kursus yang disetujui untuk filter
        $approvedCourses = Course::where('status', 'approved')->get();

        // Data Manajemen Mahasiswa
        $mahasiswaQuery = User::where('role_id', $mahasiswaRoleId);

        if ($request->filled('search_mahasiswa')) {
            $mahasiswaQuery->where('name', 'like', '%' . $request->search_mahasiswa . '%');
        }

        if ($request->filled('kelas_filter') && $request->kelas_filter != 'all') {
            $mahasiswaQuery->whereHas('enrollments', function ($query) use ($request) {
                $query->where('course_id', $request->kelas_filter);
            });
        }
        
        $mahasiswas = $mahasiswaQuery->with('enrollments.course')->latest()->get();

        return view('admin.dashboard', [
            'admin' => $admin,
            'totalDosen' => $totalDosen,
            'totalMahasiswa' => $totalMahasiswa,
            'totalKelas' => $totalKelas,
            'totalMateri' => $totalMateri,
            'dosens' => $dosens,
            'mahasiswas' => $mahasiswas,
            'kelasList' => $allCourses,
            'approvedCourses' => $approvedCourses,
            'materials' => $materials, // Kirim data materi ke view
            'request' => $request
        ]);
    }
    
    // ... (Semua fungsi lain seperti storeDosen, updateDosen, dll. tetap sama) ...

    public function storeDosen(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim_nidn' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $dosenRoleId = Role::where('name', 'dosen')->firstOrFail()->id;

        User::create([
            'name' => $request->name,
            'nim_nidn' => $request->nim_nidn,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $dosenRoleId,
            'status' => 'active',
        ]);

        return redirect()->to(url()->previous() . '#dosen')->with('success', 'Akun dosen berhasil dibuat!');
    }

    public function updateDosen(Request $request, User $dosen): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim_nidn' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($dosen->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($dosen->id)],
            'password' => ['nullable', Rules\Password::defaults()],
        ]);

        $updateData = [
            'name' => $request->name,
            'nim_nidn' => $request->nim_nidn,
            'email' => $request->email,
        ];
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $dosen->update($updateData);

        return redirect()->to(url()->previous() . '#dosen')->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function destroyDosen(User $dosen): RedirectResponse
    {
        $dosen->delete();
        return redirect()->to(url()->previous() . '#dosen')->with('success', 'Akun dosen berhasil dihapus.');
    }

    public function approveKelas(Course $kelas): RedirectResponse
    {
        $kelas->update(['status' => 'approved', 'approved_at' => now()]);
        return redirect()->to(url()->previous() . '#kelas')->with('success', 'Kelas berhasil disetujui!');
    }

    public function rejectKelas(Course $kelas): RedirectResponse
    {
        $kelas->update(['status' => 'rejected']);
        return redirect()->to(url()->previous() . '#kelas')->with('success', 'Kelas berhasil ditolak.');
    }

    public function toggleMahasiswaStatus(User $mahasiswa): RedirectResponse
    {
        $newStatus = $mahasiswa->status === 'active' ? 'inactive' : 'active';
        $mahasiswa->update(['status' => $newStatus]);
        $message = "Status mahasiswa {$mahasiswa->name} berhasil diubah menjadi {$newStatus}.";
        return redirect()->to(url()->previous() . '#mahasiswa')->with('success', $message);
    }
}