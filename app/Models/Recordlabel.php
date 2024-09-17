<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordlabel extends Model
{
    use HasFactory;

    protected $table = 'recordlabel';

    protected $fillable = ['nama', 'country'];

    public function songs()
    {
        return $this->hasMany(Song::class, 'rl_id'); // Relasi ke Song
    }
}
