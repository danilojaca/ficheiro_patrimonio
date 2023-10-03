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
        Schema::create('salas', function (Blueprint $table) {
            $table->id();
            $table->string('sala');
            $table->unsignedBigInteger('unidade_id')->nullable();
            $table->unsignedBigInteger('edificio_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->foreign('edificio_id')->references('id')->on('edificios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salas');
    }
};
