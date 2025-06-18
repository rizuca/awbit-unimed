<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $lecturerCourseIds = Auth::user()->lecturedCourses()->where('status', 'approved')->pluck('id');
        $materials = Material::whereHas('section.course', function ($query) use ($lecturerCourseIds) {
            $query->whereIn('course_id', $lecturerCourseIds);
        })->with('section.course')->latest()->get();
        return view('dosen.materials.index', compact('materials'));
    }

    public function create()
    {
        $sections = Section::whereHas('course', function ($query) {
            $query->where('lecturer_id', Auth::id())->where('status', 'approved');
        })->with('course')->get();
        return view('dosen.materials.create', compact('sections'));
    }

    public function store(Request $request)
    {
        // ... (kode store Anda sudah benar)
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:book,ppt,video,file',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,mp4,mov,epub|max:20480',
        ]);
        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
        }
        Material::create($request->except('_token') + ['file_path' => $path]);
        return redirect()->route('dosen.materials.index')->with('success', 'Media pembelajaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit media.
     * INI FUNGSI YANG BARU DITAMBAHKAN
     */
    public function edit(Material $material)
    {
        // Autorisasi sederhana
        if ($material->section->course->lecturer_id != Auth::id()) {
            abort(403);
        }

        $sections = Section::whereHas('course', function ($query) {
            $query->where('lecturer_id', Auth::id())->where('status', 'approved');
        })->with('course')->get();

        return view('dosen.materials.edit', compact('material', 'sections'));
    }

    /**
     * Memperbarui data media di database.
     * INI FUNGSI YANG BARU DITAMBAHKAN
     */
    public function update(Request $request, Material $material)
    {
        if ($material->section->course->lecturer_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:book,ppt,video,file',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,mp4,mov,epub|max:20480',
        ]);
        
        $path = $material->file_path;
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            // Simpan file baru
            $path = $request->file('file')->store('materials', 'public');
        }

        $material->update($request->except('_token', '_method', 'file') + ['file_path' => $path]);

        return redirect()->route('dosen.materials.index')->with('success', 'Media pembelajaran berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        // ... (kode destroy Anda sudah benar)
        if ($material->section->course->lecturer_id != Auth::id()) {
            abort(403);
        }
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        return redirect()->route('dosen.materials.index')->with('success', 'Media pembelajaran berhasil dihapus.');
    }
}