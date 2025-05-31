<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistropedidosTable extends Migration
{
    public function up()
    {
        Schema::create('registropedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos');
            $table->string('mesa', 50);
            $table->text('pedido');
            $table->text('detalle')->nullable();
            $table->string('estado')->comment('Estado en este registro');
            $table->decimal('total', 10, 2);
            $table->dateTime('fecha_hora_pedido')->comment('Cuando se hizo el pedido');
            $table->dateTime('fecha_hora_registro')->useCurrent()->comment('Cuando se registró');
            $table->longText('items_json')->nullable();
            
            $table->index('pedido_id');
            $table->index('mesa');
            $table->index('fecha_hora_pedido');
            $table->index('estado');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registropedidos');
    }
} 