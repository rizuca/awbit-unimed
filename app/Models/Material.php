<?php
// Lokasi: app/Models/Material.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'section_id',
        'title',
        'type',
        'content',
        'file_path',
        'points_reward',
    ];

    /**
     * Mendefinisikan relasi bahwa sebuah Material dimiliki oleh (belongs to) satu Section.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
