<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    protected $table = 'forum_threads';

    protected $fillable = [
        'title',
        'body',
        'user_id',
        // add other fields as needed
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