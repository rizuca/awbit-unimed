<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'section_id',
        'title',
        'description',
        'type',
        'due_date',
        'points_possible',
    ];

    /**
     * Mendefinisikan relasi ke Section.
     */
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Mendefinisikan relasi ke AssignmentSubmission.
     */
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'assignment_id');
    }
}