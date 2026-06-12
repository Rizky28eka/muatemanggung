<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Portofolio foto & video MUA
        Schema::create('mua_portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->constrained()->cascadeOnDelete();
            $table->string('file_path')->nullable();
            $table->text('embed_url')->nullable();
            $table->enum('file_type', ['photo', 'video'])->default('photo');
            $table->string('caption')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Vektor biner MUA untuk Cosine Similarity
        Schema::create('mua_vectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->unique()->constrained()->cascadeOnDelete();
            $table->json('vector_data');
            $table->timestamp('updated_at')->nullable();
        });

        // Log riwayat pencarian preferensi klien
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->json('preference_data');
            $table->foreignId('top1_mua_id')->nullable()->constrained('muas')->nullOnDelete();
            $table->foreignId('top2_mua_id')->nullable()->constrained('muas')->nullOnDelete();
            $table->foreignId('top3_mua_id')->nullable()->constrained('muas')->nullOnDelete();
            $table->json('similarity_scores')->nullable();
            $table->timestamp('searched_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_logs');
        Schema::dropIfExists('mua_vectors');
        Schema::dropIfExists('mua_portfolios');
    }
};
