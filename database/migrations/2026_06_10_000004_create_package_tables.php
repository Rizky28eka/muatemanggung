<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Template paket per jenis acara (dibuat oleh Admin)
        Schema::create('package_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_type_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Include/benefit default per template paket
        Schema::create('package_template_includes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_template_id')->constrained()->cascadeOnDelete();
            $table->string('include_item');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Paket yang dipilih MUA via checklist
        Schema::create('mua_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_template_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_available')->default(false);
            $table->text('custom_description')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['mua_id', 'package_template_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mua_packages');
        Schema::dropIfExists('package_template_includes');
        Schema::dropIfExists('package_templates');
    }
};
