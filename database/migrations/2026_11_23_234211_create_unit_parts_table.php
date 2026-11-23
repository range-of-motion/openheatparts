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
        Schema::create('unit_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('part_id')->constrained()->restrictOnDelete();
            $table->unsignedSmallInteger('diagram_number');
            $table->string('part_number')->nullable();
            $table->decimal('position_x', 5, 2)->nullable();
            $table->decimal('position_y', 5, 2)->nullable();
            $table->json('specs')->nullable();
            $table->string('confidence')->default('unverified');
            $table->timestamps();

            $table->unique(['unit_id', 'diagram_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_parts');
    }
};
