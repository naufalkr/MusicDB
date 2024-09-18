<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('favorite_song', function (Blueprint $table) {
            $table->id();
            $table->foreignId('favorite_id')->constrained('favorite')->onDelete('cascade');
            $table->foreignId('song_id')->constrained('song')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('favorite_song');
    }
};


Schema::create('favorite_song', function (Blueprint $table) {
    $table->id();
    $table->foreignId('favorite_id')->constrained('favorite')->onDelete('cascade');
    $table->foreignId('song_id')->constrained('song')->onDelete('cascade');
    $table->timestamps();
});
