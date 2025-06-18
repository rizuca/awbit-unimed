<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Course;
use App\Models\Material;
use App\Models\AssignmentSubmission;

class DashboardController extends Controller
{
    public function index(): View
    {
        $dosen = Auth::user();

        // Eager load semua relasi yang dibutuhkan untuk seluruh section di dashboard
        $courses = $dosen->lecturedCourses()
                         ->with([
                             'sections.assignments.submissions', // Untuk Section, Assignment, dan Penilaian
                             'students' // Untuk Mahasiswa Kelas
                         ])
                         ->get();

        // Mengambil ID dari kelas-kelas yang disetujui untuk statistik
        $approvedCourseIds = $courses->where('status', 'approved')->pluck('id');
        
        // Menghitung statistik untuk ditampilkan di kartu dashboard
        $totalStudents = User::where('role_id', 3)
                              ->whereHas('enrollments', fn($q) => $q->whereIn('course_id', $approvedCourseIds))
                              ->distinct('users.id')->count();
        
        $activeCoursesCount = $approvedCourseIds->count();
        
        $pendingSubmissionsCount = AssignmentSubmission::whereNull('grade')
            ->whereHas('assignment.section.course.lecturer', fn($q) => $q->where('id', $dosen->id))
            ->count();
            
        $materialsCount = Material::whereHas('section.course.lecturer', fn($q) => $q->where('id', $dosen->id))
            ->count();

        return view('dosen.dashboard', [
            'courses' => $courses,
            'totalStudents' => $totalStudents,
            'activeCoursesCount' => $activeCoursesCount,
            'pendingSubmissionsCount' => $pendingSubmissionsCount,
            'materialsCount' => $materialsCount,
        ]);
    }
}