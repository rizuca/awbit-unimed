<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Assignment;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // Mengambil semua kelas yang diikuti mahasiswa
        $enrolledCourses = $student->courses()->with('lecturer')->get();

        // Menghitung total poin mahasiswa
        // Asumsi ada relasi 'points()' di model User: return $this->hasMany(UserPoint::class);
        $totalPoints = $student->points()->sum('points');

        // Mengambil badge terakhir yang didapat
        // Asumsi ada relasi 'badges()' di model User
        $currentBadge = $student->badges()->latest('awarded_at')->first();

        // Mencari tugas dengan tenggat waktu terdekat
        $enrolledCourseIds = $enrolledCourses->pluck('id');
        $nextAssignment = Assignment::whereHas('section.course', function ($query) use ($enrolledCourseIds) {
            $query->whereIn('id', $enrolledCourseIds);
        })->where('due_date', '>', now())->orderBy('due_date', 'asc')->first();

        // Menghitung progress pembelajaran (contoh sederhana)
        // Anda perlu logika lebih kompleks di sini
        $totalMaterials = 100; // Placeholder
        $completedMaterials = 75; // Placeholder
        $learningProgress = ($totalMaterials > 0) ? ($completedMaterials / $totalMaterials) * 100 : 0;

        // Data untuk leaderboard (contoh untuk satu kelas)
        $firstCourse = $enrolledCourses->first();
        $leaderboard = [];
        if ($firstCourse) {
            $leaderboard = User::whereHas('enrollments', function ($query) use ($firstCourse) {
                $query->where('course_id', $firstCourse->id);
            })
            ->withSum('points', 'points') // Menjumlahkan poin dari relasi
            ->orderBy('points_sum', 'desc')
            ->take(5)
            ->get();
        }


        return view('mahasiswa.dashboard', [
            'student' => $student,
            'enrolledCourses' => $enrolledCourses,
            'totalPoints' => $totalPoints,
            'currentBadge' => $currentBadge,
            'nextAssignment' => $nextAssignment,
            'learningProgress' => $learningProgress,
            'leaderboard' => $leaderboard,
            'firstCourseName' => $firstCourse->name ?? 'Kelas',
            'unreadNotificationsCount' => $student->unreadNotifications()->count(),
        ]);
    }
}