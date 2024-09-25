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
        // Tabel episode
        Schema::create('episode', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('podcast_id')->constrained('show')->onDelete('cascade'); // Foreign key to singer
            // $table->string('album');
            $table->year('year')->nullable();
            $table->string('release_date')->nullable();            
            $table->integer('duration')->nullable();
            // $table->string('music_company')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episode');
    }
};
