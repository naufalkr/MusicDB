<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $table = 'show';

    protected $fillable = ['nama', 'release_date', 'image_url'];

    public function episodes()
    {
        return $this->hasMany(Episode::class, 'podcast_id'); // Relasi ke Episode
    }
}
