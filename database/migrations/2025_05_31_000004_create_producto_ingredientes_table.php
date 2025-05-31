<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoIngredientesTable extends Migration
{
    public function up()
    {
        Schema::create('producto_ingredientes', function (Blueprint $table) {
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('ingrediente_id')->constrained('ingredientes');
            $table->primary(['producto_id', 'ingrediente_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('producto_ingredientes');
    }
} 