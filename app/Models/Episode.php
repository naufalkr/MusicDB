<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'episode';

    protected $fillable = [
        'title',           
        'podcast_id',       
        // 'album',       
        // 'podcast_id',        
        'year',    
        'release_date',            
        'duration',  
        // 'music_company',  
        // 'rl_id',  
        'description',
    ];

    
    public function podcast()
    {
        return $this->belongsTo(Show::class, 'podcast_id'); // Relasi ke Singer
    }
    
}
