<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function create()
    {
        // Ambil section milik dosen yang kelasnya sudah disetujui
        $sections = Section::whereHas('course', function ($query) {
            $query->where('lecturer_id', Auth::id())->where('status', 'approved');
        })->with('course')->get();
        
        return view('dosen.assignments.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:multiple_choice,essay,file_upload',
            'due_date' => 'required|date',
            'points_possible' => 'required|integer|min:0',
        ]);

        // Autorisasi: Pastikan section_id yang dipilih adalah milik dosen yang login
        $section = Section::findOrFail($request->section_id);
        if ($section->course->lecturer_id != Auth::id()) {
            abort(403);
        }

        Assignment::create($request->all());

        return redirect()->route('dosen.dashboard')->with('success', 'Assignment berhasil dibuat.');
    }
    
    // Anda bisa melanjutkan untuk membuat fungsi edit, update, dan destroy dengan logika serupa
}