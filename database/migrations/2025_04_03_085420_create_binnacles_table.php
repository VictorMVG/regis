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
        Schema::create('binnacles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->OnDelete('restrict');
            $table->foreignId('headquarter_id')->constrained()->OnDelete('restrict');
            $table->foreignId('observation_type_id')->constrained('observation_types')->OnDelete('restrict');
            $table->string('title');
            $table->text('observation');
            $table->json('images')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binnacles');
    }
};
