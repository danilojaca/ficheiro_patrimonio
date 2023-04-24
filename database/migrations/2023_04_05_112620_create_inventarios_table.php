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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('edificio_id');          
            $table->string('categoria');
            $table->string('sub_categoria');
            $table->string('sala');
            $table->string('modelo')->nullable();            
            $table->string('n_inventario')->nullable()->unique();
            $table->string('n_serie')->nullable()->unique();
            $table->string('bem_inventariado');
            $table->string('conservacao'); 
            $table->timestamps();
            $table->foreign('edificio_id')->references('id')->on('edificios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
