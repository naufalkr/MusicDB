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
        'title',           // Title of the book
        'artist',         // Author of the book
        'album',        // Publisher
        'year',    // Year of publication
        'duration',  // Number of pages
        'music_company',            // MUSIC_COMPANY number
        'genre',        // Category (if not using the pivot table relationship)
        'description',       // Description of the book
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'song_genre','song_id', 'genre_id'); // Explicitly define the pivot table name
    }
    
}
