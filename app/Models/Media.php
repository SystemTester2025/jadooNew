<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'filename',
        'path',
        'mime_type',
        'size',
        'alt_text',
    ];

    /**
     * Get the full URL for the media file
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return asset($this->path);
    }
} 