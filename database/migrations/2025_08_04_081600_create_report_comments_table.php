<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user yang melaporkan
            $table->foreignId('comment_id')->constrained('comments')->onDelete('cascade'); // komentar yang dilaporkan

            // Detail laporan
            $table->string('alasan'); // alasan singkat
            $table->text('deskripsi')->nullable(); // deskripsi tambahan

            // Proses admin
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // status laporan
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // admin yang memproses
            $table->text('admin_notes')->nullable(); // catatan admin
            $table->timestamp('reviewed_at')->nullable(); // waktu direview

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_comments');
    }
};
