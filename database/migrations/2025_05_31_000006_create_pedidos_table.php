<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('mesa', 50);
            $table->text('pedido');
            $table->text('detalle')->nullable();
            $table->string('estado')->default('pendiente');
            $table->decimal('total', 10, 2);
            $table->dateTime('fecha_hora');
            $table->longText('items_json')->nullable();
            $table->timestamps();
            
            $table->index('estado');
            $table->index('mesa');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
} 