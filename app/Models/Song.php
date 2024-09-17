<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'song';

    protected $fillable = [
        'title',           
        'artist_id',       // Foreign key for artist
        'album',        
        'year',    
        'duration',  
        'music_company',  
        'description',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'song_genre', 'song_id', 'genre_id');
    }

    public function artist()
    {
        return $this->belongsTo(Singer::class, 'artist_id'); // Relasi ke Singer
    }
}
