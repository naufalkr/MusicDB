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
    
    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'buku_genre', 'genre_id', 'buku_id'); // Explicitly define the pivot table name
    }
}
