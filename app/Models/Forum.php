<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Forum extends Model
{
    protected $table = 'forums';

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class);
    }
}