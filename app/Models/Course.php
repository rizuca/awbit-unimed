<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'course_code',
        'lecturer_id',
        'status',
        'approved_at' // Penambahan kolom ini
    ];

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollments', 'course_id', 'student_id')
                    ->withTimestamps()
                    ->withPivot('enrolled_at');
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }
    public function forumThreads()
    {
        return $this->hasManyThrough(ForumThread::class, Forum::class);
    }
    public function sections()
{
    return $this->hasMany(Section::class, 'course_id');
}
}