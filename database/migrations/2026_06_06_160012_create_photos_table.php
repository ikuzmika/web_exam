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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('competition_id')->nullable()->constrained('competitions')->onDelete('cascade');
            $table->foreignId('pair_id')->nullable()->constrained('pairs')->onDelete('cascade');
            $table->foreignId('track_id')->nullable()->constrained('tracks')->onDelete('cascade');
            $table->string('title', 200)->nullable();
            $table->string('file_path');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
