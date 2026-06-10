<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MUA ↔ Jenis Acara
        Schema::create('mua_event_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_type_id')->constrained()->cascadeOnDelete();
            $table->unique(['mua_id', 'event_type_id']);
        });

        // MUA ↔ Tema
        Schema::create('mua_themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->constrained()->cascadeOnDelete();
            $table->foreignId('theme_id')->constrained()->cascadeOnDelete();
            $table->unique(['mua_id', 'theme_id']);
        });

        // MUA ↔ Jenis Tema
        Schema::create('mua_theme_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->constrained()->cascadeOnDelete();
            $table->foreignId('theme_type_id')->constrained()->cascadeOnDelete();
            $table->unique(['mua_id', 'theme_type_id']);
        });

        // MUA ↔ Look Makeup
        Schema::create('mua_makeup_looks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->constrained()->cascadeOnDelete();
            $table->foreignId('makeup_look_id')->constrained()->cascadeOnDelete();
            $table->unique(['mua_id', 'makeup_look_id']);
        });

        // MUA ↔ Kecamatan yang dilayani
        Schema::create('mua_districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->constrained()->cascadeOnDelete();
            $table->foreignId('district_id')->constrained()->cascadeOnDelete();
            $table->unique(['mua_id', 'district_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mua_districts');
        Schema::dropIfExists('mua_makeup_looks');
        Schema::dropIfExists('mua_theme_types');
        Schema::dropIfExists('mua_themes');
        Schema::dropIfExists('mua_event_types');
    }
};
