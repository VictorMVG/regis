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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->OnDelete('restrict');
            $table->foreignId('headquarter_id')->constrained()->OnDelete('restrict');
            $table->string('visitor_name');
            $table->string('company_name');
            $table->string('reason');
            $table->string('to_see');
            $table->boolean('alcohol_test');
            $table->boolean('unit');
            $table->string('unit_plate')->nullable();
            $table->foreignId('unit_type_id')->nullable()->constrained()->OnDelete('restrict');
            $table->string('unit_model')->nullable();
            $table->string('unit_number')->nullable();
            $table->foreignId('unit_color_id')->nullable()->constrained()->OnDelete('restrict');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->timestamp('exit_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
