<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Menampilkan daftar submission untuk sebuah assignment.
     */
    public function index(Assignment $assignment)
    {
        // Autorisasi: Pastikan assignment ini milik dosen yang login
        if ($assignment->section->course->lecturer_id != Auth::id()) {
            abort(403);
        }

        $submissions = $assignment->submissions()->with('user')->get();

        return view('dosen.submissions.index', compact('assignment', 'submissions'));
    }

    /**
     * Menyimpan nilai dan feedback untuk sebuah submission.
     */
    public function grade(Request $request, AssignmentSubmission $submission)
    {
        // Autorisasi: Pastikan submission ini milik assignment dari dosen yang login
        if ($submission->assignment->section->course->lecturer_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'grade' => 'required|numeric|min:0|max:' . $submission->assignment->points_possible,
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
            'graded_by' => Auth::id(),
            'graded_at' => now(),
        ]);

        return back()->with('success', 'Nilai berhasil disimpan.');
    }
}