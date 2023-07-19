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
        Schema::create('permission_unidades', function (Blueprint $table) {
           
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('unidade_id');            
            $table->timestamps();
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_unidades');
    }
};
