<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $table = 'album';

    protected $fillable = ['nama', 'release_date'];

    public function songs()
    {
        return $this->hasMany(Song::class, 'albm_id'); // Relasi ke Song
    }
}
