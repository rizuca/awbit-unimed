<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'icon_path',
        'required_points',
        'type',
    ];

    /**
     * Mendefinisikan relasi many-to-many ke User.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges', 'badge_id', 'user_id');
    }
}