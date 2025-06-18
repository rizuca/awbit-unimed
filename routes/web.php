<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\ProfileController as DosenProfileController;
use App\Http\Controllers\Dosen\CourseController; 
use App\Http\Controllers\Dosen\MaterialController;
use App\Http\Controllers\Dosen\SectionController;
use App\Http\Controllers\Dosen\AssignmentController;
use App\Http\Controllers\Dosen\SubmissionController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\ProfileController as MahasiswaProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman utama untuk semua pengunjung
Route::get('/', function () {
    return view('welcome'); });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'redirect.role'])->name('dashboard');

// Route untuk manajemen profil pengguna yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grup untuk semua route Admin
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Route untuk Pengaturan Profil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Routes untuk Manajemen Dosen
    Route::post('/dosen', [AdminDashboardController::class, 'storeDosen'])->name('dosen.store');
    Route::patch('/dosen/{dosen}', [AdminDashboardController::class, 'updateDosen'])->name('dosen.update');
    Route::delete('/dosen/{dosen}', [AdminDashboardController::class, 'destroyDosen'])->name('dosen.destroy');

    // Routes untuk Manajemen Kelas
    Route::patch('/kelas/{kelas}/approve', [AdminDashboardController::class, 'approveKelas'])->name('kelas.approve');
    Route::patch('/kelas/{kelas}/reject', [AdminDashboardController::class, 'rejectKelas'])->name('kelas.reject');
    
    // Route untuk Manajemen Mahasiswa
    Route::patch('/mahasiswa/{mahasiswa}/toggle-status', [AdminDashboardController::class, 'toggleMahasiswaStatus'])->name('mahasiswa.toggleStatus');

});

// Route Grup untuk Dosen, dilindungi oleh middleware 'role'
// Route Grup untuk Dosen, dilindungi oleh middleware 'role'
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    
    // Dashboard utama dosen
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
    
    // Route untuk pengajuan kelas
    Route::get('/kelas/create', [CourseController::class, 'create'])->name('kelas.create');
    Route::post('/kelas', [CourseController::class, 'store'])->name('kelas.store');

    // Mendaftarkan semua route CRUD untuk setiap fitur
    Route::resource('/materials', MaterialController::class);
    Route::resource('/sections', SectionController::class);
    Route::resource('/assignments', AssignmentController::class);

    // Route untuk menampilkan detail submission per assignment
    Route::get('/submissions/{assignment}', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::patch('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
});

// Route Grup untuk Mahasiswa, dilindungi oleh middleware 'role'
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    // Tambahkan route mahasiswa lainnya di sini
});

// Memuat route otentikasi (login, register, logout, dll.)
require __DIR__.'/auth.php';