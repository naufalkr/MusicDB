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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Title buku
            $table->string('artist'); // Nama artist
            $table->string('album'); // Nama album
            $table->year('year')->nullable(); // Tahun terbit
            $table->integer('duration')->nullable(); // Jumlah halaman
            $table->string('music_company')->unique(); // MUSIC_COMPANY buku
            $table->text('description')->nullable(); // Description buku
            $table->timestamps(); // Timestamps created_at dan updated_at
        });

        Schema::create('genre', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        
        Schema::create('buku_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
            $table->foreignId('genre_id')->constrained('genre')->onDelete('cascade');
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_genre'); // Drop the pivot table first
        Schema::dropIfExists('genre');      // Then drop the genre table
        Schema::dropIfExists('buku');          // Finally, drop the buku table
    }
    
};
