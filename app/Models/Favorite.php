<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorite';

    protected $fillable = ['nama', 'release_date'];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'favorite_song', 'favorite_id', 'song_id');
    }
}
