<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function create()
    {
        $courses = Auth::user()->lecturedCourses()->where('status', 'approved')->get();
        return view('dosen.sections.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'week_number' => 'required|integer|min:1',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $course = Course::where('id', $request->course_id)->where('lecturer_id', Auth::id())->firstOrFail();

        $section = new Section($request->all());
        $course->sections()->save($section);

        return redirect()->route('dosen.dashboard', ['#section'])->with('success', 'Section baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit section.
     */
    public function edit(Section $section)
    {
        // Autorisasi: Pastikan dosen hanya bisa mengedit section miliknya
        if ($section->course->lecturer_id != Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $courses = Auth::user()->lecturedCourses()->where('status', 'approved')->get();
        return view('dosen.sections.edit', compact('section', 'courses'));
    }

    /**
     * Memperbarui data section di database.
     */
    public function update(Request $request, Section $section)
    {
        if ($section->course->lecturer_id != Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'week_number' => 'required|integer|min:1',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);
        
        Course::where('id', $request->course_id)->where('lecturer_id', Auth::id())->firstOrFail();
        
        $section->update($request->all());

        return redirect()->route('dosen.dashboard', ['#section'])->with('success', 'Section berhasil diperbarui.');
    }

    /**
     * Menghapus section dari database.
     */
    public function destroy(Section $section)
    {
        if ($section->course->lecturer_id != Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $section->delete();
        return redirect()->route('dosen.dashboard', ['#section'])->with('success', 'Section berhasil dihapus.');
    }
}