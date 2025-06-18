<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id', 'name', 'email', 'password', 'nim_nidn', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'student_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_enrollments', 'student_id', 'course_id')
                    ->withTimestamps()
                    ->withPivot('enrolled_at');
    }
    public function points()
    {
        return $this->hasMany(UserPoint::class, 'user_id');
    }
        public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges', 'user_id', 'badge_id')
                    ->withTimestamps();
    }
    //     public function Assignment()
    // {
    //     return $this->belongsToMany(Assignment::class, 'user_id')
    //                 ->withTimestamps();
    // }

    public function lecturedCourses()
    {
        return $this->hasMany(Course::class, 'lecturer_id');
    }
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            // Mengambil URL dari file yang ada di storage/app/public
            return Storage::disk('public')->url($this->profile_photo_path);
        }

        // Default jika tidak ada foto
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=fff';
    }
}