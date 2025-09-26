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
        Schema::create("tareas",function(Blueprint $table){
            $table->id()->autoIncrement()->nullable(false);
            $table->string("nombre",100)->nullable(false);
            $table->string("descrip",100)->nullable(false);
            $table->enum('estado', ['completado', 'pendiente'])->default('pendiente');
            $table->integer("puntos")->nullable(false);
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("tareas");
    }
};
