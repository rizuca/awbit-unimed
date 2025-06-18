<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Menampilkan form untuk membuat (mengajukan) kelas baru.
     */
    public function create()
    {
        return view('dosen.kelas.create');
    }

    /**
     * Menyimpan data kelas baru yang diajukan ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'description' => 'nullable|string',
        ]);

        Course::create([
            'name' => $request->name,
            'course_code' => $request->course_code,
            'description' => $request->description,
            'lecturer_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->route('dosen.dashboard')->with('success', 'Kelas baru berhasil diajukan dan sedang menunggu persetujuan admin.');
    }
}