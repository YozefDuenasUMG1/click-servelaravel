<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura', 50);
            $table->dateTime('fecha');
            $table->string('cliente', 100)->default('Consumidor Final');
            $table->string('nit', 20)->default('C/F');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuesto', 10, 2);
            $table->decimal('total', 10, 2);
            $table->text('items');
            $table->text('datos_restaurante');
            $table->enum('estado', ['activa', 'anulada'])->default('activa');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
} 