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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('image')->nullable();
            $table->string('title');
            $table->longText('description');
            $table->string('isbn')->nullable();
            $table->date('publication_date');
            $table->double('price');
            $table->string('currency');
            $table->unsignedInteger('quantity');
            $table->string('author');
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
