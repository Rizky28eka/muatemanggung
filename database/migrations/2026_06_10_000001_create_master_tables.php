<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jenis Acara (Akad, Resepsi, Lamaran, Siraman, Prewed, Wisuda, Yearbook, Character, Tari)
        Schema::create('event_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_siraman')->default(false);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Tema Acara (Adat, Modern)
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Jenis Tema (Jawa, Sunda, Nusantara, Modern)
        Schema::create('theme_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Sub Jenis Tema (Klasik, Modern Klasik, Modifikasi khusus Nusantara)
        Schema::create('theme_subtypes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_type_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Look Makeup (Soft, Bold, Barbie Look, Natural, Korean, Spesialisasi)
        Schema::create('makeup_looks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Kecamatan di Temanggung
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Range Harga / Budget
        Schema::create('price_ranges', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->unsignedBigInteger('min_price')->nullable();
            $table->unsignedBigInteger('max_price')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_ranges');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('makeup_looks');
        Schema::dropIfExists('theme_subtypes');
        Schema::dropIfExists('theme_types');
        Schema::dropIfExists('themes');
        Schema::dropIfExists('event_types');
    }
};
