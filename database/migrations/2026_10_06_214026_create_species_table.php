<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //up() instrucción de construir
    public function up(): void
        {
            Schema::create('species', function (Blueprint $table) {
            //crea un número de id único que sube automáticamente    
            $table->id();
                //crea la columna para el nombre del animal
                $table->string('name')->unique();
            });
        }
        //down() deshacer, se usa si destruimos o reiniciamos la tabla
        public function down(): void
        {
            Schema::dropIfExists('species');
        }
};
