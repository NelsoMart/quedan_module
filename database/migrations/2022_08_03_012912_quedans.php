<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Quedans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quedans', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->bigInteger('num_quedan');
            $table->date('fecha_emi');
            $table->decimal('cant_num'); // Importante: debe ser decimal(17,2)
            $table->bigInteger('hiden'); // Ojo. debe ser null por default

      // // $table->bigInteger('factura_id')->unsigned();
            $table->bigInteger('fuente_id')->unsigned();
            $table->bigInteger('proyecto_id')->unsigned();
            $table->bigInteger('proveedor_id')->unsigned();
            $table->timestamps();
            
      // // $table->foreign('factura_id')->references('id')->on('facturas')->onDelete("cascade");
            $table->foreign('fuente_id')->references('id')->on('fuentes')->onDelete("no action");
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete("no action");
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quedans');
    }
}
