<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel song
        Schema::create('song', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('artist_id')->constrained('singer')->onDelete('cascade'); // Foreign key to singer
            $table->foreignId('albm_id')->constrained('album')->onDelete('cascade'); // Foreign key to singer
            $table->foreignId('rl_id')->constrained('recordlabel')->onDelete('cascade'); // Foreign key to singer
            // $table->string('album');
            $table->year('year')->nullable();
            $table->integer('duration')->nullable();
            // $table->string('music_company')->unique();
            $table->text('category')->nullable();
            $table->text('description')->nullable();            
            $table->timestamps();
        });

        // Tabel genre
        Schema::create('genre', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        // Pivot table song_genre
        Schema::create('song_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('song_id')->constrained('song')->onDelete('cascade');
            $table->foreignId('genre_id')->constrained('genre')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_genre');
        Schema::dropIfExists('genre');
        Schema::dropIfExists('song');
    }
};
