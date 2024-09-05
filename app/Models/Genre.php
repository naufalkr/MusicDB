<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    use Searchable;
    
    protected $table = 'genre'; // Explicitly set the table name if necessary

    protected $fillable = [
        'nama',
    ];
    
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'song_genre', 'genre_id', 'song_id'); // Explicitly define the pivot table name
    }
}
