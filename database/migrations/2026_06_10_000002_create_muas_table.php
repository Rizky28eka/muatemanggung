<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('muas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('instagram_username')->nullable();
            $table->boolean('is_home_service')->default(false);
            $table->unsignedInteger('service_radius_km')->default(0);
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Relasi MUA ↔ user account
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('mua_id')->nullable()->after('is_active')->constrained('muas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['mua_id']);
            $table->dropColumn('mua_id');
        });
        Schema::dropIfExists('muas');
    }
};
