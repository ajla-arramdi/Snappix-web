<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // yang berkomentar
            $table->foreignId('post_foto_id')->constrained('post_fotos')->onDelete('cascade'); // postingan foto yang dikomentari
            $table->text('content'); // isi komentar

            // Moderasi
            $table->boolean('is_banned')->default(false); // status banned
            $table->timestamp('banned_at')->nullable(); // waktu banned
            $table->foreignId('banned_by')->nullable()->constrained('users')->onDelete('set null'); // admin/mod yang membanned
            $table->text('ban_reason')->nullable(); // alasan banned

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
