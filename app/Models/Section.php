<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'week_number',
        'start_date',
        'end_date',
        'description',
    ];

    /**
     * Mendefinisikan relasi bahwa sebuah section dimiliki oleh satu course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Mendefinisikan relasi bahwa sebuah Section memiliki banyak Assignment.
     * INI ADALAH FUNGSI YANG PERLU ANDA TAMBAHKAN.
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'section_id');
    }
}