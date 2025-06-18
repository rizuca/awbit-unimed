<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $table = 'assignment_submissions';

    protected $fillable = [
        'assignment_id',
        'user_id',
        'submitted_at',
        'file_path',
        'grade',
        'feedback',
    ];

    protected $dates = [
        'submitted_at',
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}