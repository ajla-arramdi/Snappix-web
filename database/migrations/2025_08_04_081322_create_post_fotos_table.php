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
        Schema::create('post_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('album_id')->nullable()->constrained()->onDelete('set null');
            $table->string('caption');
            $table->string('image')->nullable();
            $table->boolean('is_banned')->default(false);
            $table->timestamp('banned_at')->nullable();
            $table->foreignId('banned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('ban_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_fotos');
    }
};


