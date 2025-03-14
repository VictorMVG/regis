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
        Schema::create('headquarters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->OnDelete('restrict');
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('status_id')->default(1)->constrained()->OnDelete('restrict');
            $table->timestamps();

            // indices compuestos
            $table->unique(['company_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headquarters');
    }
};
