<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Singer extends Model
{
    use HasFactory;

    protected $table = 'singer';

    protected $fillable = ['nama', 'bio'];

    public function songs()
    {
        return $this->hasMany(Song::class, 'artist_id'); // Relasi ke Song
    }
}
